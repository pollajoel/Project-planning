<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @ApiResource()
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:read")
     * 
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("user:read")
     */
    private $firstName;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups("user:read")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:read")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:read")
     */
    private $login;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, inversedBy="addressUser", cascade={"persist", "remove"})
     *  
     */
    private $userAddress;

    public function getId(): ?int
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
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

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getUserAddress(): ?Address
    {
        return $this->userAddress;
    }

    public function setUserAddress(?Address $userAddress): self
    {
        $this->userAddress = $userAddress;

        return $this;
    }
}
