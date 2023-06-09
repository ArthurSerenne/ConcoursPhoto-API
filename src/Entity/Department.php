<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\DepartmentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact',
    'regionCode' => 'exact',
    'code' => 'exact',
    'name' => 'partial',
    'slug' => 'partial',
    'users' => 'exact',
    'contests' => 'exact',
])]
#[ORM\Entity(repositoryClass: DepartmentsRepository::class)]
#[ApiResource(
    description: 'Department',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['department']],
    denormalizationContext: ['groups' => ['department']],
)]
class Department
{
    #[Groups(['department', 'contest', 'user', 'organization'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['department', 'contest', 'user', 'organization'])]
    #[ORM\Column(name: 'region_code')]
    private ?int $regionCode = null;

    #[Groups(['department', 'contest', 'user', 'organization'])]
    #[ORM\Column]
    private ?int $code = null;

    #[Groups(['department', 'contest', 'user', 'organization'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['department', 'contest', 'user', 'organization'])]
    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[Groups(['department'])]
    #[ORM\OneToMany(mappedBy: 'zipCode', targetEntity: User::class)]
    private Collection $users;

    #[Groups(['department'])]
    #[ORM\OneToMany(mappedBy: 'zipCode', targetEntity: Organization::class)]
    private Collection $organizations;

    #[Groups(['department'])]
    #[ORM\ManyToMany(targetEntity: Contest::class, mappedBy: 'departments')]
    private Collection $contests;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->organizations = new ArrayCollection();
        $this->contests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegionCode(): ?int
    {
        return $this->regionCode;
    }

    public function setRegionCode(int $regionCode): self
    {
        $this->regionCode = $regionCode;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setZipCode($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getZipCode() === $this) {
                $user->setZipCode(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Organization>
     */
    public function getOrganizations(): Collection
    {
        return $this->organizations;
    }

    public function addOrganization(Organization $organization): self
    {
        if (!$this->organizations->contains($organization)) {
            $this->organizations->add($organization);
            $organization->setZipCode($this);
        }

        return $this;
    }

    public function removeOrganization(Organization $organization): self
    {
        if ($this->organizations->removeElement($organization)) {
            // set the owning side to null (unless already changed)
            if ($organization->getZipCode() === $this) {
                $organization->setZipCode(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contest>
     */
    public function getContests(): Collection
    {
        return $this->contests;
    }

    public function addContest(Contest $contest): self
    {
        if (!$this->contests->contains($contest)) {
            $this->contests->add($contest);
            $contest->addDepartment($this);
        }

        return $this;
    }

    public function removeContest(Contest $contest): self
    {
        if ($this->contests->removeElement($contest)) {
            $contest->removeDepartment($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name.' '.$this->code;
    }
}
