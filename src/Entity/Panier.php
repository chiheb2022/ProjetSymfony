<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $prixtotal = null;

    #[ORM\ManyToOne]
    private ?User $iduserpanier = null;

    #[ORM\ManyToMany(targetEntity: Produit::class)]
    private Collection $idproduitP;

    public function __construct()
    {
        $this->idproduitP = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixtotal(): ?float
    {
        return $this->prixtotal;
    }

    public function setPrixtotal(float $prixtotal): self
    {
        $this->prixtotal = $prixtotal;

        return $this;
    }

    public function getIduserpanier(): ?User
    {
        return $this->iduserpanier;
    }

    public function setIduserpanier(?User $iduserpanier): self
    {
        $this->iduserpanier = $iduserpanier;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getIdproduitP(): Collection
    {
        return $this->idproduitP;
    }

    public function addIdproduitP(Produit $idproduitP): self
    {
        if (!$this->idproduitP->contains($idproduitP)) {
            $this->idproduitP->add($idproduitP);
        }

        return $this;
    }

    public function removeIdproduitP(Produit $idproduitP): self
    {
        $this->idproduitP->removeElement($idproduitP);

        return $this;
    }
}
