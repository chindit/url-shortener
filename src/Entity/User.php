<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $socialId;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $lastLogin;

    /**
     * @ORM\Column(type="array")
     * @var array<string>
     */
    private array $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="Link", mappedBy="user")
     * @var Collection<int, Link>
     */
    private Collection $links;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->lastLogin = new \DateTime();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSocialId(): ?string
    {
        return $this->socialId;
    }

    public function setSocialId(?string $socialId): self
    {
        $this->socialId = $socialId;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function updateLogin(): self
    {
        $this->lastLogin = new \DateTime();

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param array<string> $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt(): string
    {
        return '';
    }

    public function getUsername(): ?string
    {
        return $this->getEmail();
    }

    public function eraseCredentials(): void
    {
        // Useless
    }
}
