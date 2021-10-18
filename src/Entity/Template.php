<?php

namespace App\Entity;

use App\Repository\TemplateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TemplateRepository::class)
 */
class Template
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $liquidFilename;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $liquidSource;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $twigFilename;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $twigSource;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLiquidFilename(): ?string
    {
        return $this->liquidFilename;
    }

    public function setLiquidFilename(string $liquidFilename): self
    {
        $this->liquidFilename = $liquidFilename;

        return $this;
    }

    public function getLiquidSource(): ?string
    {
        return $this->liquidSource;
    }

    public function setLiquidSource(?string $liquidSource): self
    {
        $this->liquidSource = $liquidSource;

        return $this;
    }

    public function getTwigFilename(): ?string
    {
        return $this->twigFilename;
    }

    public function setTwigFilename(string $twigFilename): self
    {
        $this->twigFilename = $twigFilename;

        return $this;
    }

    public function getTwigSource(): ?string
    {
        return $this->twigSource;
    }

    public function setTwigSource(?string $twigSource): self
    {
        $this->twigSource = $twigSource;

        return $this;
    }

    public function liquidLineCount(): int
    {
        return substr_count( $this->getLiquidSource(), "\n" )+1;
    }

    public function twigLineCount(): int
    {
        return substr_count( $this->getTwigSource(), "\n" )+1;
    }

}
