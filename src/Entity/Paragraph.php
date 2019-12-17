<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParagraphRepository")
 * @ORM\Table(name="Paragraphs")
 */
class Paragraph
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="ParagraphID", type="string")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Work")
     * @ORM\JoinColumn(name="WorkID", referencedColumnName="WorkID", nullable=false)
     */
    private $work;

    /**
     * @ORM\Column(name="PlainText", type="text", nullable=true)
     */
    private $plainText;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Chapter", inversedBy="paragraphs")
     * @ORM\JoinColumn(name="Chapter", referencedColumnName="ChapterID")
     */
    private $scene;

    /**
     * @ORM\Column(name="Section", type="integer")
     */
    private $section;

    /**
     * @ORM\Column(name="CharID", type="string", length=32, nullable=true)
     */
    private $charId;

    /**
     * @ORM\Column(name="ParagraphType", type="string", length=1, nullable=true)
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPlainText(): ?string
    {
        return $this->plainText;
    }

    public function setPlainText(?string $plainText): self
    {
        $this->plainText = $plainText;

        return $this;
    }

    public function __toString() {
        return $this->getPlainText();
    }

    public function getScene(): ?Chapter
    {
        return $this->scene;
    }

    public function setScene(?Chapter $scene): self
    {
        $this->scene = $scene;

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

    public function getCharId(): ?string
    {
        return $this->charId;
    }

    public function setCharId(?string $charId): self
    {
        $this->charId = $charId;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

}
