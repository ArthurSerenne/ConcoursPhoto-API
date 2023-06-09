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
use App\Repository\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact',
    'status' => 'exact',
    'name' => 'partial',
    'type' => 'exact',
    'description' => 'partial',
    'logo' => 'partial',
    'address' => 'partial',
    'country' => 'partial',
    'website' => 'partial',
    'email' => 'partial',
    'phone' => 'partial',
    'rents' => 'exact',
    'sponsors' => 'exact',
    'users' => 'exact',
    'contests' => 'exact',
    'zipCodes' => 'exact',
    'cities' => 'exact',
    'siret' => 'partial',
    'vat' => 'partial',
    'deletionDate' => 'exact',
])]
#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
#[ApiResource(
    description: 'Organization',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['organization']],
    denormalizationContext: ['groups' => ['organization']],
)]
#[ORM\Table(name: '`organization`')]
class Organization
{
    #[Groups(['organization', 'contest', 'user', 'rent'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['organization', 'contest', 'user', 'rent'])]
    #[ORM\Column(nullable: true)]
    private ?bool $status = null;

    #[Groups(['organization', 'contest', 'user', 'rent'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['organization', 'contest', 'user', 'rent'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[Groups(['organization', 'contest', 'user', 'rent'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[Groups(['organization', 'contest', 'user', 'rent'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[Groups(['organization', 'contest', 'user', 'rent'])]
    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[Groups(['organization', 'contest', 'user', 'rent'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[Groups(['organization', 'contest', 'user', 'rent'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[Groups(['organization', 'contest', 'user', 'rent'])]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Groups(['organization', 'contest', 'user', 'rent'])]
    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[Groups(['organization', 'user', 'rent'])]
    #[ORM\OneToMany(mappedBy: 'organization', targetEntity: Rent::class)]
    private Collection $rents;

    #[Groups(['organization', 'user', 'rent'])]
    #[ORM\OneToMany(mappedBy: 'organization', targetEntity: Sponsor::class)]
    private Collection $sponsors;

    #[Groups(['organization'])]
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'organizations')]
    private Collection $users;

    #[Groups(['organization', 'user'])]
    #[ORM\OneToMany(mappedBy: 'organization', targetEntity: Contest::class)]
    private Collection $contests;

    #[Groups(['organization', 'contest', 'user'])]
    #[ORM\ManyToOne(inversedBy: 'organizations')]
    #[ORM\JoinColumn(name: 'zip_code_id', nullable: true)]
    private ?Department $zipCode = null;

    #[Groups(['organization', 'contest', 'user'])]
    #[ORM\ManyToOne(inversedBy: 'organizations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

    #[Groups(['organization', 'contest', 'user', 'rent'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siret = null;

    #[Groups(['organization', 'contest', 'user', 'rent'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vat = null;

    #[Groups(['organization', 'contest', 'user', 'rent'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updateDate = null;

    #[Groups(['organization', 'contest', 'user', 'rent'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletionDate = null;

    #[Groups(['organization', 'contest', 'user'])]
    #[ORM\OneToOne(mappedBy: 'organization', targetEntity: 'SocialNetwork', cascade: ['persist', 'remove'])]
    private $socialNetwork;

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

    public function setStatus(?bool $status): self
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

    public function setLogo(?string $logo): self
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

    public function getZipCode(): ?Department
    {
        return $this->zipCode;
    }

    public function setZipCode(?Department $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getVat(): ?string
    {
        return $this->vat;
    }

    public function setVat(?string $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    public function setUpdateDate(?\DateTimeInterface $updateDate): self
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    public function getDeletionDate(): ?\DateTimeInterface
    {
        return $this->deletionDate;
    }

    public function setDeletionDate(?\DateTimeInterface $deletionDate): self
    {
        $this->deletionDate = $deletionDate;

        return $this;
    }

    public function getSocialNetwork(): ?SocialNetwork
    {
        return $this->socialNetwork;
    }

    public function setSocialNetwork(SocialNetwork $socialNetwork): self
    {
        // set the owning side of the relation if necessary
        if ($socialNetwork->getOrganization() !== $this) {
            $socialNetwork->setOrganization($this);
        }

        $this->socialNetwork = $socialNetwork;

        return $this;
    }
}
