<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\PreferenciesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PreferenciesRepository::class)]
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
    normalizationContext: ['groups' => ['preferencies']],
    denormalizationContext: ['groups' => ['preferencies']],
)]
#[ORM\Table(name: '`preferencies`')]
class Preferencies
{
    #[Groups(['preferencies', 'user'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['preferencies', 'user'])]
    #[ORM\Column(nullable: true)]
    private ?bool $newContest = null;

    #[Groups(['preferencies', 'user'])]
    #[ORM\Column(nullable: true)]
    private ?bool $voteContest = null;

    #[Groups(['preferencies', 'user'])]
    #[ORM\Column(nullable: true)]
    private ?bool $endContest = null;

    #[Groups(['preferencies', 'user'])]
    #[ORM\Column(nullable: true)]
    private ?bool $resultContest = null;

    #[Groups(['preferencies', 'user'])]
    #[ORM\Column(nullable: true)]
    private ?bool $blog = null;

    #[Groups(['preferencies', 'user'])]
    #[ORM\Column(nullable: true)]
    private ?bool $newContestProfil = null;

    #[Groups(['preferencies', 'user'])]
    #[ORM\Column(nullable: true)]
    private ?bool $submissionContest = null;

    #[Groups(['preferencies', 'user'])]
    #[ORM\Column(nullable: true)]
    private ?bool $endSubmissionContest = null;

    #[ORM\OneToOne(inversedBy: 'preferencies', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isNewContest(): ?bool
    {
        return $this->newContest;
    }

    public function setNewContest(?bool $newContest): self
    {
        $this->newContest = $newContest;

        return $this;
    }

    public function isVoteContest(): ?bool
    {
        return $this->voteContest;
    }

    public function setVoteContest(?bool $voteContest): self
    {
        $this->voteContest = $voteContest;

        return $this;
    }

    public function isEndContest(): ?bool
    {
        return $this->endContest;
    }

    public function setEndContest(?bool $endContest): self
    {
        $this->endContest = $endContest;

        return $this;
    }

    public function isResultContest(): ?bool
    {
        return $this->resultContest;
    }

    public function setResultContest(?bool $resultContest): self
    {
        $this->resultContest = $resultContest;

        return $this;
    }

    public function isBlog(): ?bool
    {
        return $this->blog;
    }

    public function setBlog(?bool $blog): self
    {
        $this->blog = $blog;

        return $this;
    }

    public function isNewContestProfil(): ?bool
    {
        return $this->newContestProfil;
    }

    public function setNewContestProfil(?bool $newContestProfil): self
    {
        $this->newContestProfil = $newContestProfil;

        return $this;
    }

    public function isSubmissionContest(): ?bool
    {
        return $this->submissionContest;
    }

    public function setSubmissionContest(?bool $submissionContest): self
    {
        $this->submissionContest = $submissionContest;

        return $this;
    }

    public function isEndSubmissionContest(): ?bool
    {
        return $this->endSubmissionContest;
    }

    public function setEndSubmissionContest(?bool $endSubmissionContest): self
    {
        $this->endSubmissionContest = $endSubmissionContest;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
