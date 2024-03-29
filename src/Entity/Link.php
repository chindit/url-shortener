<?php

namespace App\Entity;

use App\Repository\LinkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use App\Validator\Constraint as CustomAssert;

/**
 * @ORM\Entity(repositoryClass=LinkRepository::class)
 */
class Link
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=36, unique=true)
     */
    private string $token;

    /**
     * Assert\Url
     * @CustomAssert\Online
     *
     * @ORM\Column(type="string", length=255)
     */
    private string $target;

    /**
     * @ORM\Column(type="integer")
     */
    private int $views = 0;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="links")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private ?User $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $lastView;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $createdAt;

    public function __construct()
    {
        $this->id = Uuid::v4();
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

    public static function addLink(string $link) : self
    {
        return (new Link())
            ->setTarget($link);
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(string $target): self
    {
        $this->target = $target;

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

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): ?User
    {
         return $this->user;
    }

    public function setClicked(): self
    {
        $this->views++;
        $this->lastView = new \DateTime();

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getLastView(): ?\DateTimeInterface
    {
        return $this->lastView;
    }
}
