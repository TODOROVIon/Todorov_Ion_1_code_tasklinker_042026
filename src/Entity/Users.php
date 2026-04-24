<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà utilisé.')]

class Users implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $first__name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $access_level = null;

    #[ORM\Column(length: 255)]
    private ?string $contract_type = null;

    #[ORM\Column]
    private ?\DateTime $enter_date = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    /**
     * @var Collection<int, Tache>
     */
    #[ORM\OneToMany(targetEntity: Tache::class, mappedBy: 'idUser')]
    private Collection $taches;

    /**
     * @var Collection<int, TimeTable>
     */
    #[ORM\OneToMany(targetEntity: TimeTable::class, mappedBy: 'idUser')]
    private Collection $timeTables;

    /**
     * @var Collection<int, Project>
     */
    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'users')]
    private Collection $projects;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
        $this->timeTables = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first__name;
    }

    public function setFirstName(string $first__name): static
    {
        $this->first__name = $first__name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getAccessLevel(): ?string
    {
        return $this->access_level;
    }

    public function setAccessLevel(string $access_level): static
    {
        $this->access_level = $access_level;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = [];

        if ($this->access_level === 'Admin') {
            $roles[] = 'ROLE_ADMIN';
        } elseif ($this->access_level === 'Chef de projet') {
            $roles[] = 'ROLE_CHEF_PROJET';
        } else {
            $roles[] = 'ROLE_DEVELOPPEUR';
        }

        return array_unique($roles);
    }

    public function eraseCredentials(): void
{
        $this->password = null;
}

    public function getContractType(): ?string
    {
        return $this->contract_type;
    }

    public function setContractType(string $contract_type): static
    {
        $this->contract_type = $contract_type;

        return $this;
    }

    public function getEnterDate(): ?\DateTime
    {
        return $this->enter_date;
    }

    public function setEnterDate(\DateTime $enter_date): static
    {
        $this->enter_date = $enter_date;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    /**
     * @return Collection<int, Tache>
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Tache $tach): static
    {
        if (!$this->taches->contains($tach)) {
            $this->taches->add($tach);
            $tach->setIdUser($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): static
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getIdUser() === $this) {
                $tach->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TimeTable>
     */
    public function getTimeTables(): Collection
    {
        return $this->timeTables;
    }

    public function addTimeTable(TimeTable $timeTable): static
    {
        if (!$this->timeTables->contains($timeTable)) {
            $this->timeTables->add($timeTable);
            $timeTable->setIdUser($this);
        }

        return $this;
    }

    public function removeTimeTable(TimeTable $timeTable): static
    {
        if ($this->timeTables->removeElement($timeTable)) {
            // set the owning side to null (unless already changed)
            if ($timeTable->getIdUser() === $this) {
                $timeTable->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->addUser($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            $project->removeUser($this);
        }

        return $this;
    }

    public function getInitials(): string
    {
        $firstInitial = $this->first__name ? strtoupper($this->first__name[0]) : '';
        $lastInitial = $this->last_name ? strtoupper($this->last_name[0]) : '';

        return $firstInitial.$lastInitial;
    }
}
