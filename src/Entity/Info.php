<?php

namespace App\Entity;

use App\Repository\InfoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfoRepository::class)]
class Info
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url_property = null;

    #[ORM\ManyToOne(inversedBy: 'infos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Property $property_id = null;

    #[ORM\OneToMany(mappedBy: 'info', targetEntity: Image::class, cascade: ['persist', 'remove'])]
    private Collection $image;

    public function __construct()
    {
        $this->image = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlProperty(): ?string
    {
        return $this->url_property;
    }

    public function setUrlProperty(string $url_property): static
    {
        $this->url_property = $url_property;

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
            $image->setInfo($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getInfo() === $this) {
                $image->setInfo(null);
            }
        }

        return $this;
    }
}
