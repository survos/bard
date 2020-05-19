<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Survos\BaseBundle\Entity\SurvosBaseEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CharacterRepository")
 * @ORM\Table(name="Characters")
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}},
 *
 *     attributes={
 *          "pagination_items_per_page"=10,
 *          "pagination_client_items_per_page"=true
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"name": "partial", "description": "partial"})
 *
 */
class Character extends SurvosBaseEntity
{
    const ICON = 'fas fa-user';
    /**
     * @ORM\Id()
     * @ORM\Column(name="CharID", type="string")
     */
    private $id;


    /**
     * @ORM\Column(name="CharName", type="string", length=48)
     * @Groups({"read"})
     */
    private $name;

    /**
     * @ORM\Column(name="Description", type="string", length=255)
     * @Groups({"read"})
     */
    private $description;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId($charId): self
    {
        $this->id = $charId;
        return $this;
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

    function getUniqueIdentifiers()
    {
        return ['characterId' => $this->getId()];
    }
}
