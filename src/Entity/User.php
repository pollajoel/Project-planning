<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity("email")
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
     * @Assert\Email
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

    /**
     * @ORM\OneToMany(targetEntity=Projects::class, mappedBy="users")
     */
    private $projects_user_work;

    /**
     * @ORM\OneToMany(targetEntity=Projects::class, mappedBy="manager")
     */
    private $projects_user_manage;

    public function __construct()
    {
        $this->projects_user_work = new ArrayCollection();
        $this->projects_user_manage = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Projects>
     */
    public function getProjectsUserWork(): Collection
    {
        return $this->projects_user_work;
    }

    public function addProjectsUserWork(Projects $projectsUserWork): self
    {
        if (!$this->projects_user_work->contains($projectsUserWork)) {
            $this->projects_user_work[] = $projectsUserWork;
            $projectsUserWork->setUsers($this);
        }

        return $this;
    }

    public function removeProjectsUserWork(Projects $projectsUserWork): self
    {
        if ($this->projects_user_work->removeElement($projectsUserWork)) {
            // set the owning side to null (unless already changed)
            if ($projectsUserWork->getUsers() === $this) {
                $projectsUserWork->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Projects>
     */
    public function getProjectsUserManage(): Collection
    {
        return $this->projects_user_manage;
    }

    public function addProjectsUserManage(Projects $projectsUserManage): self
    {
        if (!$this->projects_user_manage->contains($projectsUserManage)) {
            $this->projects_user_manage[] = $projectsUserManage;
            $projectsUserManage->setManager($this);
        }

        return $this;
    }

    public function removeProjectsUserManage(Projects $projectsUserManage): self
    {
        if ($this->projects_user_manage->removeElement($projectsUserManage)) {
            // set the owning side to null (unless already changed)
            if ($projectsUserManage->getManager() === $this) {
                $projectsUserManage->setManager(null);
            }
        }

        return $this;
    }
}
