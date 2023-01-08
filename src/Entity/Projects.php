<?php

namespace App\Entity;

use App\Repository\ProjectsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=ProjectsRepository::class)
 *  @UniqueEntity("projectName")
 */
class Projects
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("project:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups("project:read")
     */
    private $projectName;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Groups("project:read")
     * @Assert\LessThanOrEqual(propertyPath="endDate", message="The date must be later than the end date")
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Groups("project:read")
     * @Assert\GreaterThan(propertyPath="start_date", message="The date must be greater than the start date")
     */
    private $end_date;

    /**
     * @ORM\OneToOne(targetEntity=ProjectType::class, inversedBy="projects", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Groups("project:read")
     */
    private $project_type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projects_user_work")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projects_user_manage")
     */
    private $manager;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectName(): ?string
    {
        return $this->projectName;
    }

    public function setProjectName(string $projectName): self
    {
        $this->projectName = $projectName;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getProjectType(): ?ProjectType
    {
        return $this->project_type;
    }

    public function setProjectType(ProjectType $project_type): self
    {
        $this->project_type = $project_type;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getManager(): ?User
    {
        return $this->manager;
    }

    public function setManager(?User $manager): self
    {
        $this->manager = $manager;

        return $this;
    }
}
