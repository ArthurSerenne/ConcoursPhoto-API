<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\RegionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RegionsRepository::class)]
#[ApiResource(
    description: 'Region',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['region']],
    denormalizationContext: ['groups' => ['region']],
)]
class Region
{
    #[Groups(['region', 'contest', 'organization'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['region', 'contest', 'organization'])]
    #[ORM\Column]
    private ?int $code = null;

    #[Groups(['region', 'contest', 'organization'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['region', 'contest', 'organization'])]
    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[Groups(['region'])]
    #[ORM\ManyToMany(targetEntity: Contest::class, mappedBy: 'regions')]
    private Collection $contests;

    public function __construct()
    {
        $this->contests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

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
            $contest->addRegion($this);
        }

        return $this;
    }

    public function removeContest(Contest $contest): self
    {
        if ($this->contests->removeElement($contest)) {
            $contest->removeRegion($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name.' '.$this->code;
    }
}
