<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    description: 'User',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['user']],
    denormalizationContext: ['groups' => ['user']],
)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Groups(['user', 'contest'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['user', 'contest'])]
    #[ORM\Column(nullable: true)]
    private ?bool $status = null;

    #[Groups(['user', 'contest'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $creationDate = null;

    #[Groups(['user', 'contest'])]
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $gender = null;

    #[Groups(['user', 'contest'])]
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[Groups(['user', 'contest'])]
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[Groups(['user', 'contest'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $birthdate = null;

    #[Groups(['user', 'contest'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[Groups(['user', 'contest'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[Groups(['user', 'contest'])]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[Groups(['user', 'contest'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    /**
     * @var string The hashed password
     */
    #[Groups(['user', 'contest'])]
    #[ORM\Column]
    private ?string $password = null;

    #[Groups(['user', 'contest'])]
    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[Groups(['user'])]
    #[ORM\ManyToMany(targetEntity: Organization::class, inversedBy: 'users')]
    private Collection $organizations;

    #[Groups(['user'])]
    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist'])]
    private ?Member $member = null;

    #[Groups(['user'])]
    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Department $zipCode = null;

    #[Groups(['user'])]
    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: true)]
    private ?City $city = null;

    #[Groups(['user'])]
    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Preferencies $preferencies = null;

    public function __construct()
    {
        $this->organizations = new ArrayCollection();
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

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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
        }

        return $this;
    }

    public function removeOrganization(Organization $organization): self
    {
        $this->organizations->removeElement($organization);

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(Member $member): self
    {
        // set the owning side of the relation if necessary
        if ($member->getUser() !== $this) {
            $member->setUser($this);
        }

        $this->member = $member;

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

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function __toString()
    {
        return $this->firstname.' '.$this->lastname;
    }

    public function getPreferencies(): ?Preferencies
    {
        return $this->preferencies;
    }

    public function setPreferencies(?Preferencies $preferencies): self
    {
        // unset the owning side of the relation if necessary
        if (null === $preferencies && null !== $this->preferencies) {
            $this->preferencies->setUser(null);
        }

        // set the owning side of the relation if necessary
        if (null !== $preferencies && $preferencies->getUser() !== $this) {
            $preferencies->setUser($this);
        }

        $this->preferencies = $preferencies;

        return $this;
    }
}
