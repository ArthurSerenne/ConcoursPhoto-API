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
use App\Repository\CitiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiFilter(SearchFilter::class, properties: [
        'id' => 'exact',
        'departmentCode' => 'exact',
        'insee_code' => 'exact',
        'zip_code' => 'partial',
        'name' => 'partial',
        'slug' => 'partial',
        'latitude' => 'exact',
        'longitude' => 'exact',
        'users' => 'exact',
        'contests' => 'exact',
    ]
)]
#[ORM\Entity(repositoryClass: CitiesRepository::class)]
#[ApiResource(
    description: 'City',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['city']],
    denormalizationContext: ['groups' => ['city']],
)]
class City
{
    #[Groups(['city', 'contest', 'user'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['city', 'contest', 'user'])]
    #[ORM\Column(name: 'department_code')]
    private ?int $departmentCode = null;

    #[Groups(['city', 'contest', 'user'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $insee_code = null;

    #[Groups(['city', 'contest', 'user'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $zip_code = null;

    #[Groups(['city', 'contest', 'user'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['city', 'contest', 'user'])]
    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[Groups(['city', 'contest', 'user'])]
    #[ORM\Column]
    private ?float $gps_lat = null;

    #[Groups(['city', 'contest', 'user'])]
    #[ORM\Column]
    private ?float $gps_lng = null;

    #[Groups(['city'])]
    #[ORM\OneToMany(mappedBy: 'city', targetEntity: User::class)]
    private Collection $users;

    #[Groups(['city', 'user', 'organization'])]
    #[ORM\OneToMany(mappedBy: 'city', targetEntity: Organization::class)]
    private Collection $organizations;

    #[Groups(['city'])]
    #[ORM\ManyToMany(targetEntity: Contest::class, mappedBy: 'cities')]
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

    public function getDepartmentCode(): ?int
    {
        return $this->departmentCode;
    }

    public function setDepartmentCode(int $departmentCode): self
    {
        $this->departmentCode = $departmentCode;

        return $this;
    }

    public function getInseeCode(): ?string
    {
        return $this->insee_code;
    }

    public function setInseeCode(?string $insee_code): self
    {
        $this->insee_code = $insee_code;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(?string $zip_code): self
    {
        $this->zip_code = $zip_code;

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

    public function getGpsLat(): ?float
    {
        return $this->gps_lat;
    }

    public function setGpsLat(float $gps_lat): self
    {
        $this->gps_lat = $gps_lat;

        return $this;
    }

    public function getGpsLng(): ?float
    {
        return $this->gps_lng;
    }

    public function setGpsLng(float $gps_lng): self
    {
        $this->gps_lng = $gps_lng;

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
            $user->setCity($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCity() === $this) {
                $user->setCity(null);
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
            $organization->setCity($this);
        }

        return $this;
    }

    public function removeOrganization(Organization $organization): self
    {
        if ($this->organizations->removeElement($organization)) {
            // set the owning side to null (unless already changed)
            if ($organization->getCity() === $this) {
                $organization->setCity(null);
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
            $contest->addCity($this);
        }

        return $this;
    }

    public function removeContest(Contest $contest): self
    {
        if ($this->contests->removeElement($contest)) {
            $contest->removeCity($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name.' '.$this->zip_code;
    }
}
