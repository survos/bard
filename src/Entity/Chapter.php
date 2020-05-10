<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Survos\LandingBundle\Entity\SurvosBaseEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChapterRepository")
 * @ORM\Table(name="Chapters")
 */
class Chapter extends SurvosBaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="ChapterID", type="string")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Work", inversedBy="chapters", fetch="EAGER")
     * @ORM\JoinColumn(name="WorkID", referencedColumnName="WorkID", nullable=false)
     */
    private $work;

    /**
     * @ORM\Column(name="Section", type="integer")
     */
    private $section;

    /**
     * @ORM\Column(name="Chapter", type="string", length=255)
     */
    private $scene;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Paragraph", mappedBy="scene", orphanRemoval=true, fetch="EAGER")
     */
    private $paragraphs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->paragraphs = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getWork(): ?Work
    {
        return $this->work;
    }

    public function setWork(?Work $work): self
    {
        $this->work = $work;

        return $this;
    }

    public function getSection(): ?int
    {
        return $this->section;
    }

    public function setSection(int $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getScene(): ?string
    {
        return $this->scene;
    }

    public function setScene(string $scene): self
    {
        $this->scene = $scene;

        return $this;
    }

    /**
     * @return Collection|Paragraph[]
     */
    public function getParagraphs(): Collection
    {
        return $this->paragraphs;
    }

    public function addParagraph(Paragraph $paragraph): self
    {
        if (!$this->paragraphs->contains($paragraph)) {
            $this->paragraphs[] = $paragraph;
            $paragraph->setScene($this);
        }

        return $this;
    }

    public function removeParagraph(Paragraph $paragraph): self
    {
        if ($this->paragraphs->contains($paragraph)) {
            $this->paragraphs->removeElement($paragraph);
            // set the owning side to null (unless already changed)
            if ($paragraph->getScene() === $this) {
                $paragraph->setScene(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        // return $this->getId();
        return sprintf("%s-%s %s", $this->getSection(), $this->getScene(), $this->getDescription());
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    function getUniqueIdentifiers()
    {
        return ['chapterId' => $this->getId()];
    }
}
