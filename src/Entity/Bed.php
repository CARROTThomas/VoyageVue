<?php

namespace App\Entity;

use App\Repository\BedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BedRepository::class)]
class Bed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'beds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BedCategory $typeBed = null;

    #[ORM\Column]
    private ?int $numberOfBed = null;

    #[ORM\ManyToOne(inversedBy: 'beds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bedroom $bedroom_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeBed(): ?BedCategory
    {
        return $this->typeBed;
    }

    public function setTypeBed(?BedCategory $typeBed): static
    {
        $this->typeBed = $typeBed;

        return $this;
    }

    public function getNumberOfBed(): ?int
    {
        return $this->numberOfBed;
    }

    public function setNumberOfBed(int $numberOfBed): static
    {
        $this->numberOfBed = $numberOfBed;

        return $this;
    }

    public function getBedroomId(): ?Bedroom
    {
        return $this->bedroom_id;
    }

    public function setBedroomId(?Bedroom $bedroom_id): static
    {
        $this->bedroom_id = $bedroom_id;

        return $this;
    }
}
