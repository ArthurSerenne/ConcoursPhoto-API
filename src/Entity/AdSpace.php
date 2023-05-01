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
use App\Repository\AdSpaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact',
    'status' => 'exact',
    'name' => 'partial',
    'heightPx' => 'exact',
    'widthPx' => 'exact',
    'referencePrize' => 'exact',
])]
#[ORM\Entity(repositoryClass: AdSpaceRepository::class)]
#[ApiResource(
    description: 'Ad space',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['ad_space']],
    denormalizationContext: ['groups' => ['ad_space']],
)]
#[ORM\Table(name: '`ad_space`')]
class AdSpace
{
    #[Groups(['ad_space'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['ad_space'])]
    #[ORM\Column]
    private ?bool $status = null;

    #[Groups(['ad_space'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['ad_space'])]
    #[ORM\Column]
    private ?int $heightPx = null;

    #[Groups(['ad_space'])]
    #[ORM\Column]
    private ?int $widthPx = null;

    #[Groups(['ad_space'])]
    #[ORM\Column]
    private ?int $referencePrize = null;

    #[Groups(['ad_space'])]
    #[ORM\OneToMany(mappedBy: 'adSpace', targetEntity: Rent::class)]
    private Collection $rents;

    public function __construct()
    {
        $this->rents = new ArrayCollection();
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

    public function getHeightPx(): ?int
    {
        return $this->heightPx;
    }

    public function setHeightPx(int $heightPx): self
    {
        $this->heightPx = $heightPx;

        return $this;
    }

    public function getWidthPx(): ?int
    {
        return $this->widthPx;
    }

    public function setWidthPx(int $widthPx): self
    {
        $this->widthPx = $widthPx;

        return $this;
    }

    public function getReferencePrize(): ?int
    {
        return $this->referencePrize;
    }

    public function setReferencePrize(int $referencePrize): self
    {
        $this->referencePrize = $referencePrize;

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
            $rent->setAdSpace($this);
        }

        return $this;
    }

    public function removeRent(Rent $rent): self
    {
        if ($this->rents->removeElement($rent)) {
            // set the owning side to null (unless already changed)
            if ($rent->getAdSpace() === $this) {
                $rent->setAdSpace(null);
            }
        }

        return $this;
    }
}
