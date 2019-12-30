<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CharacterRepository")
 * @ORM\Table(name="Characters")
 * @ApiResource(attributes={"pagination_client_items_per_page"=true}))
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 *
 */
class Character
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="CharID", type="string")
     */
    private $id;

    /**
     * @ORM\Column(name="CharName", type="string", length=48)
     */
    private $name;

    /**
     * @ORM\Column(name="Description", type="string", length=255)
     */
    private $description;

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
