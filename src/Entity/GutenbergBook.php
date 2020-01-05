<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GutenbergBookRepository")
 */
class GutenbergBook
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $rdf;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return GutenbergBook
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = mb_substr($title, 0, 255);

        return $this;
    }

    public function getRdf(): ?string
    {
        return $this->rdf;
    }

    public function setRdf(string $rdf): self
    {
        $this->rdf = $rdf;

        return $this;
    }

}
