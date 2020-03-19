<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Survos\LandingBundle\Entity\SurvosBaseEntity;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use ONGR\ElasticsearchBundle\Annotation as ES;
/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkRepository")
 * @ORM\Table(name="Works")
 * @ApiResource(
 *     attributes={
 *          "pagination_items_per_page"=10,
 *          "pagination_client_items_per_page"=true
 *     },
 *
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"title": "partial", "longTitle": "partial"})
 * @ApiFilter(RangeFilter::class, properties={"chapterCount", "year"})
 * @ApiFilter(NumericFilter::class, properties={"totalWords", "year"})
 */
class Work extends SurvosBaseEntity
{

    /**
     * @ORM\Id()
     * @ORM\Column(name="WorkID", type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read"})
     */
    private $title;

    /**
     * @ORM\Column(name="LongTitle", type="string", length=255, nullable=true)
     */
    private $longTitle;

    /**
     * @ORM\Column(name="ShortTitle", type="string", length=255)
     */
    private $shortTitle;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $source;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalWords;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalParagraphs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Chapter", mappedBy="work", orphanRemoval=true)
     */
    private $chapters;

    /**
     * @ORM\Column(name="GenreType", type="string", length=1, nullable=true)
     */
    private $genreType;

    /**
     * @ORM\Column(name="Date", type="integer")
     */
    private $year;

    // not persisted
    private $fountainUrl;

    public function __construct()
    {
        $this->chapters = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLongTitle(): ?string
    {
        return $this->longTitle;
    }

    public function setLongTitle(?string $longTitle): self
    {
        $this->longTitle = $longTitle;

        return $this;
    }

    public function getShortTitle(): ?string
    {
        return $this->shortTitle;
    }

    public function setShortTitle(string $shortTitle): self
    {
        $this->shortTitle = $shortTitle;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getTotalWords(): ?int
    {
        return $this->totalWords;
    }

    public function setTotalWords(int $totalWords): self
    {
        $this->totalWords = $totalWords;

        return $this;
    }

    public function getTotalParagraphs(): ?int
    {
        return $this->totalParagraphs;
    }

    public function setTotalParagraphs(int $totalParagraphs): self
    {
        $this->totalParagraphs = $totalParagraphs;

        return $this;
    }

    /**
     * @return Collection|Chapter[]
     */
    public function getChapters(): Collection
    {
        return $this->chapters;
    }

    public function addChapter(Chapter $chapter): self
    {
        if (!$this->chapters->contains($chapter)) {
            $this->chapters[] = $chapter;
            $chapter->setWork($this);
        }

        return $this;
    }

    public function removeChapter(Chapter $chapter): self
    {
        if ($this->chapters->contains($chapter)) {
            $this->chapters->removeElement($chapter);
            // set the owning side to null (unless already changed)
            if ($chapter->getWork() === $this) {
                $chapter->setWork(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getShortTitle();
    }

    function getUniqueIdentifiers()
    {
        return ['id' => $this->getId()];
    }

    public function getGenreType(): ?string
    {
        return $this->genreType;
    }

    public function setGenreType(?string $genreType): self
    {
        $this->genreType = $genreType;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getFountainUrl(): ?string
    {
        // hack, need an event subscriber to set properly
        return sprintf('/fountain/%s.fountain', $this->getId());
        return $this->fountainUrl;
    }

    public function setFountainUrl(string $fountainUrl): self
    {
        $this->fountainUrl = $fountainUrl;

        return $this;
    }

    public function getChapterCount(): int
    {
        return $this->getChapters()->count();
    }

    /* @todo
    public function getCharacterCount(): int
    {
        return $this->getCha()->count();
    }
     * */

}
