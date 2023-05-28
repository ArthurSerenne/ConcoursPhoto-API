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
use App\Repository\VoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact',
    'date_vote' => 'exact',
    'member' => 'exact',
    'photo' => 'exact',
])]
#[ORM\Entity(repositoryClass: VoteRepository::class)]
#[ApiResource(
    description: 'Vote',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['vote']],
    denormalizationContext: ['groups' => ['vote']],
)]
#[ORM\Table(name: '`vote`')]
class Vote
{
    #[Groups(['vote'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['vote'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_vote = null;

    #[Groups(['vote'])]
    #[ORM\ManyToOne(inversedBy: 'votes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Member $member = null;

    #[Groups(['vote'])]
    #[ORM\ManyToOne(inversedBy: 'votes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Photo $photo = null;

    public function __construct()
    {
        $this->date_vote = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVote(): ?\DateTimeInterface
    {
        return $this->date_vote;
    }

    public function setDateVote(?\DateTimeInterface $date_vote): self
    {
        $this->date_vote = $date_vote;

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

    public function getPhoto(): ?Photo
    {
        return $this->photo;
    }

    public function setPhoto(?Photo $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}
