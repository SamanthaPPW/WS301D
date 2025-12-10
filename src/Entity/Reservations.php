<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_proprio = null;

    #[ORM\Column(length: 20)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $creneau_date = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $creneau_heure = null;

    #[ORM\Column(length: 255)]
    private ?string $animal = null;

    #[ORM\Column(length: 255)]
    private ?string $race = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 5)]
    private ?string $code_postal = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comportement_animal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_animal = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaires = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProprio(): ?string
    {
        return $this->nom_proprio;
    }

    public function setNomProprio(string $nom_proprio): static
    {
        $this->nom_proprio = $nom_proprio;

        return $this;
    }

    public function getCreneauHeure(): ?string
    {
        return $this->creneau_heure;
    }

    public function setCreneauHeure(?string $creneau_heure): static
    {
        $this->creneau_heure = $creneau_heure;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCreneauDate(): ?\DateTime
    {
        return $this->creneau_date;
    }

    public function setCreneauDate(\DateTime $creneau_date): static
    {
        $this->creneau_date = $creneau_date;
        return $this;
    }


    public function getAnimal(): ?string
    {
        return $this->animal;
    }

    public function setAnimal(string $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): static
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getComportementAnimal(): ?string
    {
        return $this->comportement_animal;
    }

    public function setComportementAnimal(?string $comportement_animal): static
    {
        $this->comportement_animal = $comportement_animal;

        return $this;
    }

    public function getNomAnimal(): ?string
    {
        return $this->nom_animal;
    }

    public function setNomAnimal(?string $nom_animal): static
    {
        $this->nom_animal = $nom_animal;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(?string $commentaires): static
    {
        $this->commentaires = $commentaires;

        return $this;
    }
}
