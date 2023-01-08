<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\AddressRepository;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 * 
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("address:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("address:read")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=6)
     * @Groups("address:read")
     * 
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("address:read")
     * 
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="userAddress", cascade={"persist", "remove"})
     */
    private $addressUser;

    public function __construct()
    {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhone(): ?string
    {
        return $this->phone;

    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getAddressUser(): ?User
    {
        return $this->addressUser;
    }

    public function setAddressUser(?User $addressUser): self
    {
        // unset the owning side of the relation if necessary
        if ($addressUser === null && $this->addressUser !== null) {
            $this->addressUser->setUserAddress(null);
        }

        // set the owning side of the relation if necessary
        if ($addressUser !== null && $addressUser->getUserAddress() !== $this) {
            $addressUser->setUserAddress($this);
        }

        $this->addressUser = $addressUser;

        return $this;
    }
}
