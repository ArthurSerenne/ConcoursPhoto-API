<?php

namespace App\Entity;

use App\Repository\RentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RentRepository::class)]
class Rent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column]
    private ?int $click_url = null;

    #[ORM\Column(length: 255)]
    private ?string $alt_tag = null;

    #[ORM\Column]
    private ?int $price_sold = null;

    #[ORM\Column]
    private ?int $click_count = null;

    #[ORM\ManyToOne(inversedBy: 'rents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Organization $organization = null;

    #[ORM\ManyToOne(inversedBy: 'rents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AdSpace $adSpace = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getClickUrl(): ?int
    {
        return $this->click_url;
    }

    public function setClickUrl(int $click_url): self
    {
        $this->click_url = $click_url;

        return $this;
    }

    public function getAltTag(): ?string
    {
        return $this->alt_tag;
    }

    public function setAltTag(string $alt_tag): self
    {
        $this->alt_tag = $alt_tag;

        return $this;
    }

    public function getPriceSold(): ?int
    {
        return $this->price_sold;
    }

    public function setPriceSold(int $price_sold): self
    {
        $this->price_sold = $price_sold;

        return $this;
    }

    public function getClickCount(): ?int
    {
        return $this->click_count;
    }

    public function setClickCount(int $click_count): self
    {
        $this->click_count = $click_count;

        return $this;
    }

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function getAdSpace(): ?AdSpace
    {
        return $this->adSpace;
    }

    public function setAdSpace(?AdSpace $adSpace): self
    {
        $this->adSpace = $adSpace;

        return $this;
    }
}
