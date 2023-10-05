<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
class Property
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'properties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'properties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Establishment $establishment = null;

    #[ORM\OneToMany(mappedBy: 'property_id', targetEntity: Situation::class, orphanRemoval: true)]
    private Collection $situations;

    #[ORM\OneToMany(mappedBy: 'property_id', targetEntity: Info::class, orphanRemoval: true)]
    private Collection $infos;

    #[ORM\OneToMany(mappedBy: 'property_id', targetEntity: Bedroom::class, orphanRemoval: true)]
    private Collection $bedrooms;

    public function __construct()
    {
        $this->situations = new ArrayCollection();
        $this->infos = new ArrayCollection();
        $this->bedrooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEstablishment(): ?Establishment
    {
        return $this->establishment;
    }

    public function setEstablishment(?Establishment $establishment): static
    {
        $this->establishment = $establishment;

        return $this;
    }

    /**
     * @return Collection<int, Situation>
     */
    public function getSituations(): Collection
    {
        return $this->situations;
    }

    public function addSituation(Situation $situation): static
    {
        if (!$this->situations->contains($situation)) {
            $this->situations->add($situation);
            $situation->setPropertyId($this);
        }

        return $this;
    }

    public function removeSituation(Situation $situation): static
    {
        if ($this->situations->removeElement($situation)) {
            // set the owning side to null (unless already changed)
            if ($situation->getPropertyId() === $this) {
                $situation->setPropertyId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Info>
     */
    public function getInfos(): Collection
    {
        return $this->infos;
    }

    public function addInfo(Info $info): static
    {
        if (!$this->infos->contains($info)) {
            $this->infos->add($info);
            $info->setPropertyId($this);
        }

        return $this;
    }

    public function removeInfo(Info $info): static
    {
        if ($this->infos->removeElement($info)) {
            // set the owning side to null (unless already changed)
            if ($info->getPropertyId() === $this) {
                $info->setPropertyId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bedroom>
     */
    public function getBedrooms(): Collection
    {
        return $this->bedrooms;
    }

    public function addBedroom(Bedroom $bedroom): static
    {
        if (!$this->bedrooms->contains($bedroom)) {
            $this->bedrooms->add($bedroom);
            $bedroom->setPropertyId($this);
        }

        return $this;
    }

    public function removeBedroom(Bedroom $bedroom): static
    {
        if ($this->bedrooms->removeElement($bedroom)) {
            // set the owning side to null (unless already changed)
            if ($bedroom->getPropertyId() === $this) {
                $bedroom->setPropertyId(null);
            }
        }

        return $this;
    }
}
