<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Repository\AdSpaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
    ]
)]
#[ORM\Table(name: '`ad_space`')]
class AdSpace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $heightPx = null;

    #[ORM\Column]
    private ?int $widthPx = null;

    #[ORM\Column]
    private ?int $referencePrize = null;

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
