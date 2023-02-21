<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $totalproduit = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCM = null;

    #[ORM\Column(length: 255)]
    private ?string $adresselivraison = null;

    #[ORM\Column]
    private ?float $prixtot = null;

    #[ORM\Column]
    private ?int $statusCM = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Panier $idpanier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalproduit(): ?int
    {
        return $this->totalproduit;
    }

    public function setTotalproduit(int $totalproduit): self
    {
        $this->totalproduit = $totalproduit;

        return $this;
    }

    public function getDateCM(): ?\DateTimeInterface
    {
        return $this->dateCM;
    }

    public function setDateCM(\DateTimeInterface $dateCM): self
    {
        $this->dateCM = $dateCM;

        return $this;
    }

    public function getAdresselivraison(): ?string
    {
        return $this->adresselivraison;
    }

    public function setAdresselivraison(string $adresselivraison): self
    {
        $this->adresselivraison = $adresselivraison;

        return $this;
    }

    public function getPrixtot(): ?float
    {
        return $this->prixtot;
    }

    public function setPrixtot(float $prixtot): self
    {
        $this->prixtot = $prixtot;

        return $this;
    }

    public function getStatusCM(): ?int
    {
        return $this->statusCM;
    }

    public function setStatusCM(int $statusCM): self
    {
        $this->statusCM = $statusCM;

        return $this;
    }

    public function getIdpanier(): ?Panier
    {
        return $this->idpanier;
    }

    public function setIdpanier(?Panier $idpanier): self
    {
        $this->idpanier = $idpanier;

        return $this;
    }
}
