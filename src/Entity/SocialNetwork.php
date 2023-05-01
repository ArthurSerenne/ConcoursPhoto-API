<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\SocialNetworkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SocialNetworkRepository::class)]
#[ApiResource(
    description: 'SocialNetwork',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['social_network']],
    denormalizationContext: ['groups' => ['social_network']],
)]
#[ORM\Table(name: 'social_network')]
class SocialNetwork
{
    #[Groups(['social_network'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['social_network'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $facebook = null;

    #[Groups(['social_network'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $twitter = null;

    #[Groups(['social_network'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkedin = null;

    #[Groups(['social_network'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $whatsapp = null;

    #[Groups(['social_network'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtube = null;

    #[Groups(['social_network'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instagram = null;

    #[Groups(['social_network'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tiktok = null;

    #[Groups(['social_network'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $snapchat = null;

    #[Groups(['social_network'])]
    #[ORM\OneToOne(inversedBy: 'socialNetwork', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Member $member = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getWhatsapp(): ?string
    {
        return $this->whatsapp;
    }

    public function setWhatsapp(?string $whatsapp): self
    {
        $this->whatsapp = $whatsapp;

        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): self
    {
        $this->youtube = $youtube;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getTiktok(): ?string
    {
        return $this->tiktok;
    }

    public function setTiktok(?string $tiktok): self
    {
        $this->tiktok = $tiktok;

        return $this;
    }

    public function getSnapchat(): ?string
    {
        return $this->snapchat;
    }

    public function setSnapchat(?string $snapchat): self
    {
        $this->snapchat = $snapchat;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(Member $member): self
    {
        $this->member = $member;

        return $this;
    }
}
