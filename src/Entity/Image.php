<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=36, unique=true)
     */
    private string $token;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $fileName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $mime;

    /**
     * @ORM\Column(type="integer")
     */
    private int $width = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private int $height = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private int $weight = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private int $views = 0;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $lastView;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->lastView = new \DateTime();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getMime(): ?string
    {
        return $this->mime;
    }

    public function setMime(string $mime): self
    {
        $this->mime = $mime;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLastView(): ?\DateTimeInterface
    {
        return $this->lastView;
    }

    public function setLastView(\DateTimeInterface $lastView): self
    {
        $this->lastView = $lastView;

        return $this;
    }

    public function setClicked(): self
    {
        $this->views++;
        $this->lastView = new \DateTime();

        return $this;
    }
}
