<?php

namespace App\Entity;

use App\Repository\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
#[ORM\Table(name: '`organization`')]
class Organization
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $logo = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    private ?string $website = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\OneToMany(mappedBy: 'organization', targetEntity: Rent::class)]
    private Collection $rents;

    #[ORM\OneToMany(mappedBy: 'organization', targetEntity: Sponsor::class)]
    private Collection $sponsors;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'organizations')]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'organization', targetEntity: Contest::class)]
    private Collection $contests;

    #[ORM\ManyToOne(inversedBy: 'organizations')]
    private ?Departments $zipCode = null;

    #[ORM\ManyToOne(inversedBy: 'organizations')]
    private ?Cities $city = null;

    public function __construct()
    {
        $this->rents = new ArrayCollection();
        $this->sponsors = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->contests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Rent>
     */
    public function getRents(): Collection
    {
        return $this->rents;
    }

    public function addRent(Rent $rent): self
    {
        if (!$this->rents->contains($rent)) {
            $this->rents->add($rent);
            $rent->setOrganization($this);
        }

        return $this;
    }

    public function removeRent(Rent $rent): self
    {
        if ($this->rents->removeElement($rent)) {
            // set the owning side to null (unless already changed)
            if ($rent->getOrganization() === $this) {
                $rent->setOrganization(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sponsor>
     */
    public function getSponsors(): Collection
    {
        return $this->sponsors;
    }

    public function addSponsor(Sponsor $sponsor): self
    {
        if (!$this->sponsors->contains($sponsor)) {
            $this->sponsors->add($sponsor);
            $sponsor->setOrganization($this);
        }

        return $this;
    }

    public function removeSponsor(Sponsor $sponsor): self
    {
        if ($this->sponsors->removeElement($sponsor)) {
            // set the owning side to null (unless already changed)
            if ($sponsor->getOrganization() === $this) {
                $sponsor->setOrganization(null);
            }
        }

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
            $user->addOrganization($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeOrganization($this);
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
            $contest->setOrganization($this);
        }

        return $this;
    }

    public function removeContest(Contest $contest): self
    {
        if ($this->contests->removeElement($contest)) {
            // set the owning side to null (unless already changed)
            if ($contest->getOrganization() === $this) {
                $contest->setOrganization(null);
            }
        }

        return $this;
    }

    public function getZipCode(): ?Departments
    {
        return $this->zipCode;
    }

    public function setZipCode(?Departments $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?Cities
    {
        return $this->city;
    }

    public function setCity(?Cities $city): self
    {
        $this->city = $city;

        return $this;
    }
}
