<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PanierRepository")
 */
class Panier
{

    private $id;
    private $nom;
    private $id_element;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getID_element(): ?int
    {
        return $this->id_element;
    }

    public function setID_element(?Integer $id_element): self
    {
        $this->id_element = $id_element;

        return $this;
    }

}
