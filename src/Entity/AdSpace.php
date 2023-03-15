<?php

namespace App\Entity;

use App\Repository\AdSpaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdSpaceRepository::class)]
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

    #[ORM\ManyToMany(targetEntity: Organization::class, mappedBy: 'adSpaces')]
    private Collection $organizations;

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
            $organization->addAdSpace($this);
        }

        return $this;
    }

    public function removeOrganization(Organization $organization): self
    {
        if ($this->organizations->removeElement($organization)) {
            $organization->removeAdSpace($this);
        }

        return $this;
    }
}
