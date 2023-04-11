<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ApiResource(
    description: 'Member',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ]
)]
#[ORM\Table(name: '`member`')]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $registrationDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletionDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updateDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $lastLoginDate = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $situation = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(length: 255)]
    private ?string $website = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Vote::class)]
    private Collection $votes;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: JuryMember::class)]
    private Collection $juryMembers;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Photo::class)]
    private Collection $photos;

    #[ORM\OneToOne(inversedBy: 'member', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?User $user = null;

    #[ORM\OneToOne(mappedBy: 'member', targetEntity: 'SocialNetwork', cascade: ['persist', 'remove'])]
    private $socialNetwork;

    public function __construct()
    {
        $this->votes = new ArrayCollection();
        $this->juryMembers = new ArrayCollection();
        $this->photos = new ArrayCollection();
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getDeletionDate(): ?\DateTimeInterface
    {
        return $this->deletionDate;
    }

    public function setDeletionDate(\DateTimeInterface $deletionDate): self
    {
        $this->deletionDate = $deletionDate;

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    public function setUpdateDate(\DateTimeInterface $updateDate): self
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    public function getLastLoginDate(): ?\DateTimeInterface
    {
        return $this->lastLoginDate;
    }

    public function setLastLoginDate(\DateTimeInterface $lastLoginDate): self
    {
        $this->lastLoginDate = $lastLoginDate;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

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

    public function getSituation(): ?string
    {
        return $this->situation;
    }

    public function setSituation(string $situation): self
    {
        $this->situation = $situation;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

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

    /**
     * @return Collection<int, Vote>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes->add($vote);
            $vote->setMember($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getMember() === $this) {
                $vote->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, JuryMember>
     */
    public function getJuryMembers(): Collection
    {
        return $this->juryMembers;
    }

    public function addJuryMember(JuryMember $juryMember): self
    {
        if (!$this->juryMembers->contains($juryMember)) {
            $this->juryMembers->add($juryMember);
            $juryMember->setMember($this);
        }

        return $this;
    }

    public function removeJuryMember(JuryMember $juryMember): self
    {
        if ($this->juryMembers->removeElement($juryMember)) {
            // set the owning side to null (unless already changed)
            if ($juryMember->getMember() === $this) {
                $juryMember->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setMember($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getMember() === $this) {
                $photo->setMember(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSocialNetwork(): ?SocialNetwork
    {
        return $this->socialNetwork;
    }

    public function setSocialNetwork(SocialNetwork $socialNetwork): self
    {
        $this->socialNetwork = $socialNetwork;

        return $this;
    }
}
