<?php

namespace App\Entity;

use App\Repository\BedroomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BedroomRepository::class)]
class Bedroom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'bedrooms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Property $property_id = null;

    #[ORM\Column]
    private ?int $m2 = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\OneToMany(mappedBy: 'bedroom', targetEntity: Image::class, cascade: ['persist', 'remove'])]
    private Collection $image;

    public function __construct()
    {
        $this->image = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPropertyId(): ?Property
    {
        return $this->property_id;
    }

    public function setPropertyId(?Property $property_id): static
    {
        $this->property_id = $property_id;

        return $this;
    }

    public function getM2(): ?int
    {
        return $this->m2;
    }

    public function setM2(int $m2): static
    {
        $this->m2 = $m2;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): static
    {
        if (!$this->image->contains($image)) {
            $this->image->add($image);
            $image->setBedroom($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getBedroom() === $this) {
                $image->setBedroom(null);
            }
        }

        return $this;
    }
}
