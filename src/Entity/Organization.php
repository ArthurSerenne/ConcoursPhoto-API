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

    #[ORM\Column]
    private ?int $zipCode = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    private ?string $website = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'organizations')]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: AdSpace::class, inversedBy: 'organizations')]
    private Collection $adSpaces;

    #[ORM\ManyToMany(targetEntity: Contest::class, inversedBy: 'organizations')]
    private Collection $contests;

    #[ORM\OneToMany(mappedBy: 'organization', targetEntity: Contest::class)]
    private Collection $publicationContests;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->adSpaces = new ArrayCollection();
        $this->contests = new ArrayCollection();
        $this->publicationContests = new ArrayCollection();
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

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
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
     * @return Collection<int, AdSpace>
     */
    public function getAdSpaces(): Collection
    {
        return $this->adSpaces;
    }

    public function addAdSpace(AdSpace $adSpace): self
    {
        if (!$this->adSpaces->contains($adSpace)) {
            $this->adSpaces->add($adSpace);
        }

        return $this;
    }

    public function removeAdSpace(AdSpace $adSpace): self
    {
        $this->adSpaces->removeElement($adSpace);

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
        }

        return $this;
    }

    public function removeContest(Contest $contest): self
    {
        $this->contests->removeElement($contest);

        return $this;
    }

    /**
     * @return Collection<int, Contest>
     */
    public function getPublicationContests(): Collection
    {
        return $this->publicationContests;
    }

    public function addPublicationContest(Contest $publicationContest): self
    {
        if (!$this->publicationContests->contains($publicationContest)) {
            $this->publicationContests->add($publicationContest);
            $publicationContest->setOrganization($this);
        }

        return $this;
    }

    public function removePublicationContest(Contest $publicationContest): self
    {
        if ($this->publicationContests->removeElement($publicationContest)) {
            // set the owning side to null (unless already changed)
            if ($publicationContest->getOrganization() === $this) {
                $publicationContest->setOrganization(null);
            }
        }

        return $this;
    }
}
