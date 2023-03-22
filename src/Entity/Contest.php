<?php

namespace App\Entity;

use App\Repository\ContestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContestRepository::class)]
#[ORM\Table(name: '`contest`')]
class Contest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $visual = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $rules = null;

    #[ORM\Column(length: 255)]
    private ?string $prizes = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $publicationDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $submissionStartDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $submissionEndDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $votingStartDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $votingEndDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $resultsDate = null;

    #[ORM\Column]
    private ?int $juryVotePourcentage = null;

    #[ORM\Column]
    private ?int $voteMax = null;

    #[ORM\Column]
    private ?int $prizesCount = null;

    #[ORM\Column]
    private ?int $ageMin = null;

    #[ORM\Column]
    private ?int $ageMax = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\OneToMany(mappedBy: 'contest', targetEntity: Sponsor::class)]
    private Collection $sponsors;

    #[ORM\OneToMany(mappedBy: 'contest', targetEntity: JuryMember::class)]
    private Collection $juryMembers;

    #[ORM\OneToMany(mappedBy: 'contest', targetEntity: Photo::class)]
    private Collection $photos;

    #[ORM\ManyToOne(inversedBy: 'contests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Organization $organization = null;

    #[ORM\ManyToMany(targetEntity: Region::class, inversedBy: 'contests')]
    private Collection $regions;

    #[ORM\ManyToMany(targetEntity: Department::class, inversedBy: 'contests')]
    private Collection $departments;

    #[ORM\ManyToMany(targetEntity: City::class, inversedBy: 'contests')]
    private Collection $cities;

    #[ORM\OneToMany(mappedBy: 'contest', targetEntity: Win::class)]
    private Collection $wins;

    #[ORM\ManyToMany(targetEntity: Theme::class, inversedBy: 'contests')]
    private Collection $theme;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'contests')]
    private Collection $categories;

    public function __construct()
    {
        $this->sponsors = new ArrayCollection();
        $this->juryMembers = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->regions = new ArrayCollection();
        $this->departments = new ArrayCollection();
        $this->cities = new ArrayCollection();
        $this->wins = new ArrayCollection();
        $this->theme = new ArrayCollection();
        $this->categories = new ArrayCollection();
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

    public function getVisual(): ?string
    {
        return $this->visual;
    }

    public function setVisual(string $visual): self
    {
        $this->visual = $visual;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRules(): ?string
    {
        return $this->rules;
    }

    public function setRules(string $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    public function getPrizes(): ?string
    {
        return $this->prizes;
    }

    public function setPrizes(string $prizes): self
    {
        $this->prizes = $prizes;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getSubmissionStartDate(): ?\DateTimeInterface
    {
        return $this->submissionStartDate;
    }

    public function setSubmissionStartDate(\DateTimeInterface $submissionStartDate): self
    {
        $this->submissionStartDate = $submissionStartDate;

        return $this;
    }

    public function getSubmissionEndDate(): ?\DateTimeInterface
    {
        return $this->submissionEndDate;
    }

    public function setSubmissionEndDate(\DateTimeInterface $submissionEndDate): self
    {
        $this->submissionEndDate = $submissionEndDate;

        return $this;
    }

    public function getVotingStartDate(): ?\DateTimeInterface
    {
        return $this->votingStartDate;
    }

    public function setVotingStartDate(\DateTimeInterface $votingStartDate): self
    {
        $this->votingStartDate = $votingStartDate;

        return $this;
    }

    public function getVotingEndDate(): ?\DateTimeInterface
    {
        return $this->votingEndDate;
    }

    public function setVotingEndDate(\DateTimeInterface $votingEndDate): self
    {
        $this->votingEndDate = $votingEndDate;

        return $this;
    }

    public function getResultsDate(): ?\DateTimeInterface
    {
        return $this->resultsDate;
    }

    public function setResultsDate(\DateTimeInterface $resultsDate): self
    {
        $this->resultsDate = $resultsDate;

        return $this;
    }

    public function getJuryVotePourcentage(): ?int
    {
        return $this->juryVotePourcentage;
    }

    public function setJuryVotePourcentage(int $juryVotePourcentage): self
    {
        $this->juryVotePourcentage = $juryVotePourcentage;

        return $this;
    }

    public function getVoteMax(): ?int
    {
        return $this->voteMax;
    }

    public function setVoteMax(int $voteMax): self
    {
        $this->voteMax = $voteMax;

        return $this;
    }

    public function getPrizesCount(): ?int
    {
        return $this->prizesCount;
    }

    public function setPrizesCount(int $prizesCount): self
    {
        $this->prizesCount = $prizesCount;

        return $this;
    }

    public function getAgeMin(): ?int
    {
        return $this->ageMin;
    }

    public function setAgeMin(int $ageMin): self
    {
        $this->ageMin = $ageMin;

        return $this;
    }

    public function getAgeMax(): ?int
    {
        return $this->ageMax;
    }

    public function setAgeMax(int $ageMax): self
    {
        $this->ageMax = $ageMax;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, Sponsor>
     */
    public function getSponsors(): Collection
    {
        return $this->sponsors;
    }

    public function addSponsor(Sponsor $sponsor): self
    {
        if (!$this->sponsors->contains($sponsor)) {
            $this->sponsors->add($sponsor);
            $sponsor->setContest($this);
        }

        return $this;
    }

    public function removeSponsor(Sponsor $sponsor): self
    {
        if ($this->sponsors->removeElement($sponsor)) {
            // set the owning side to null (unless already changed)
            if ($sponsor->getContest() === $this) {
                $sponsor->setContest(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, JuryMember>
     */
    public function getJuryMembers(): Collection
    {
        return $this->juryMembers;
    }

    public function addJuryMember(JuryMember $juryMember): self
    {
        if (!$this->juryMembers->contains($juryMember)) {
            $this->juryMembers->add($juryMember);
            $juryMember->setContest($this);
        }

        return $this;
    }

    public function removeJuryMember(JuryMember $juryMember): self
    {
        if ($this->juryMembers->removeElement($juryMember)) {
            // set the owning side to null (unless already changed)
            if ($juryMember->getContest() === $this) {
                $juryMember->setContest(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setContest($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getContest() === $this) {
                $photo->setContest(null);
            }
        }

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

    /**
     * @return Collection<int, Region>
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegion(Region $region): self
    {
        if (!$this->regions->contains($region)) {
            $this->regions->add($region);
        }

        return $this;
    }

    public function removeRegion(Region $region): self
    {
        $this->regions->removeElement($region);

        return $this;
    }

    /**
     * @return Collection<int, Department>
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(Department $department): self
    {
        if (!$this->departments->contains($department)) {
            $this->departments->add($department);
        }

        return $this;
    }

    public function removeDepartment(Department $department): self
    {
        $this->departments->removeElement($department);

        return $this;
    }

    /**
     * @return Collection<int, City>
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): self
    {
        if (!$this->cities->contains($city)) {
            $this->cities->add($city);
        }

        return $this;
    }

    public function removeCity(City $city): self
    {
        $this->cities->removeElement($city);

        return $this;
    }

    /**
     * @return Collection<int, Win>
     */
    public function getWins(): Collection
    {
        return $this->wins;
    }

    public function addWin(Win $win): self
    {
        if (!$this->wins->contains($win)) {
            $this->wins->add($win);
            $win->setContest($this);
        }

        return $this;
    }

    public function removeWin(Win $win): self
    {
        if ($this->wins->removeElement($win)) {
            // set the owning side to null (unless already changed)
            if ($win->getContest() === $this) {
                $win->setContest(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Theme>
     */
    public function getTheme(): Collection
    {
        return $this->theme;
    }

    public function addTheme(Theme $theme): self
    {
        if (!$this->theme->contains($theme)) {
            $this->theme->add($theme);
        }

        return $this;
    }

    public function removeTheme(Theme $theme): self
    {
        $this->theme->removeElement($theme);

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
