<?php

namespace App\Entity;

use App\Repository\ProjectTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=ProjectTypeRepository::class)
 * @UniqueEntity("typeName")
 */
class ProjectType
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
     * @Groups("project:read")
     */
    private $typeName;

    /**
     * @ORM\OneToOne(targetEntity=Projects::class, mappedBy="project_type", cascade={"persist", "remove"})
     */
    private $projects;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeName(): ?string
    {
        return $this->typeName;
    }

    public function setTypeName(string $typeName): self
    {
        $this->typeName = $typeName;

        return $this;
    }

    public function getProjects(): ?Projects
    {
        return $this->projects;
    }

    public function setProjects(Projects $projects): self
    {
        // set the owning side of the relation if necessary
        if ($projects->getProjectType() !== $this) {
            $projects->setProjectType($this);
        }

        $this->projects = $projects;

        return $this;
    }
}
