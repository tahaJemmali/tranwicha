<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlatRepository")
 */
class Plat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $recette;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Ingrediant", inversedBy="plats")
     */
    private $ingrediants;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Kit", mappedBy="plats")
     */
    private $kits;

    public function __construct()
    {
        $this->ingrediants = new ArrayCollection();
        $this->kits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRecette(): ?string
    {
        return $this->recette;
    }

    public function setRecette(string $recette): self
    {
        $this->recette = $recette;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Ingrediant[]
     */
    public function getIngrediants(): Collection
    {
        return $this->ingrediants;
    }

    public function addIngrediant(Ingrediant $ingrediant): self
    {
        if (!$this->ingrediants->contains($ingrediant)) {
            $this->ingrediants[] = $ingrediant;
        }

        return $this;
    }

    public function removeIngrediant(Ingrediant $ingrediant): self
    {
        if ($this->ingrediants->contains($ingrediant)) {
            $this->ingrediants->removeElement($ingrediant);
        }

        return $this;
    }

    /**
     * @return Collection|Kit[]
     */
    public function getKits(): Collection
    {
        return $this->kits;
    }

    public function addKit(Kit $kit): self
    {
        if (!$this->kits->contains($kit)) {
            $this->kits[] = $kit;
            $kit->addPlat($this);
        }

        return $this;
    }

    public function removeKit(Kit $kit): self
    {
        if ($this->kits->contains($kit)) {
            $this->kits->removeElement($kit);
            $kit->removePlat($this);
        }

        return $this;
    }
}
