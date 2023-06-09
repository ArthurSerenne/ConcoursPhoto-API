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
use App\Repository\JuryMemberRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact',
    'invitation_date' => 'exact',
    'acceptance_date' => 'exact',
    'member' => 'exact',
    'contest' => 'exact',
])]
#[ORM\Entity(repositoryClass: JuryMemberRepository::class)]
#[ApiResource(
    description: 'Jury member',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['jury_member']],
    denormalizationContext: ['groups' => ['jury_member']],
)]
#[ORM\Table(name: 'jury_member')]
class JuryMember
{
    #[Groups(['jury_member', 'contest'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['jury_member', 'contest'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $invitation_date = null;

    #[Groups(['jury_member', 'contest'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $acceptance_date = null;

    #[Groups(['jury_member', 'contest'])]
    #[ORM\ManyToOne(inversedBy: 'juryMembers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Member $member = null;

    #[Groups(['jury_member'])]
    #[ORM\ManyToOne(inversedBy: 'juryMembers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contest $contest = null;

    #[Groups(['jury_member', 'contest'])]
    #[ORM\Column(length: 255)]
    private ?string $fonction = null;

    #[Groups(['jury_member', 'contest'])]
    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvitationDate(): ?\DateTimeInterface
    {
        return $this->invitation_date;
    }

    public function setInvitationDate(\DateTimeInterface $invitation_date): self
    {
        $this->invitation_date = $invitation_date;

        return $this;
    }

    public function getAcceptanceDate(): ?\DateTimeInterface
    {
        return $this->acceptance_date;
    }

    public function setAcceptanceDate(\DateTimeInterface $acceptance_date): self
    {
        $this->acceptance_date = $acceptance_date;

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

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function __toString(): string
    {
        return $this->contest->getName();
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
