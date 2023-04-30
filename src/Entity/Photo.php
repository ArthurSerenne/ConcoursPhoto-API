<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Repository\PhotoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact',
    'status' => 'exact',
    'name' => 'partial',
    'submissionDate' => 'exact',
    'file' => 'partial',
    'voteCount' => 'exact',
    'prizeRank' => 'exact',
    'votes' => 'exact',
    'member' => 'exact',
    'contest' => 'exact',
])]
#[ORM\Entity(repositoryClass: PhotoRepository::class)]
#[ApiResource(
    description: 'Photo',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['photo']],
    denormalizationContext: ['groups' => ['photo']],
)]
#[ORM\Table(name: '`photo`')]
class Photo
{
    #[Groups(['photo', 'contest'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['photo', 'contest'])]
    #[ORM\Column]
    private ?bool $status = null;

    #[Groups(['photo', 'contest'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['photo', 'contest'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, name: 'submission_date')]
    private ?\DateTimeInterface $submissionDate = null;

    #[Groups(['photo', 'contest'])]
    #[ORM\Column(length: 255)]
    private ?string $file = null;

    #[Groups(['photo', 'contest'])]
    #[ORM\Column(name: 'vote_count')]
    private ?int $voteCount = null;

    #[Groups(['photo', 'contest'])]
    #[ORM\Column(name: 'prize_won')]
    private ?bool $prizeWon = null;

    #[Groups(['photo', 'contest'])]
    #[ORM\Column(name: 'prize_rank')]
    private ?int $prizeRank = null;

    #[Groups(['photo'])]
    #[ORM\OneToMany(mappedBy: 'photo', targetEntity: Vote::class)]
    private Collection $votes;

    #[Groups(['photo'])]
    #[ORM\ManyToOne(inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Member $member = null;

    #[Groups(['photo'])]
    #[ORM\ManyToOne(inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contest $contest = null;

    public function __construct()
    {
        $this->votes = new ArrayCollection();
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

    public function getSubmissionDate(): ?\DateTimeInterface
    {
        return $this->submissionDate;
    }

    public function setSubmissionDate(\DateTimeInterface $submissionDate): self
    {
        $this->submissionDate = $submissionDate;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getVoteCount(): ?int
    {
        return $this->voteCount;
    }

    public function setVoteCount(int $voteCount): self
    {
        $this->voteCount = $voteCount;

        return $this;
    }

    public function isPrizeWon(): ?bool
    {
        return $this->prizeWon;
    }

    public function setPrizeWon(bool $prizeWon): self
    {
        $this->prizeWon = $prizeWon;

        return $this;
    }

    public function getPrizeRank(): ?int
    {
        return $this->prizeRank;
    }

    public function setPrizeRank(int $prizeRank): self
    {
        $this->prizeRank = $prizeRank;

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
            $vote->setPhoto($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getPhoto() === $this) {
                $vote->setPhoto(null);
            }
        }

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getContest(): ?Contest
    {
        return $this->contest;
    }

    public function setContest(?Contest $contest): self
    {
        $this->contest = $contest;

        return $this;
    }

    public function __toString()
    {
        return $this->member->getUsername();
    }
}
