<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 */
class Etudiant
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
    private $Matricule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Adresse;

    /**
     * @ORM\Column(type="integer")
     */
    private $Telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Date_de_Naissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Bourse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Type_Etudiant;

    /**
     * @ORM\ManyToOne(targetEntity=Chambre::class, inversedBy="etudiants")
     */
    private $Chambre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->Matricule;
    }

    public function setMatricule(string $Matricule): self
    {
        $this->Matricule = $Matricule;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(?string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->Telephone;
    }

    public function setTelephone(int $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getDateDeNaissance(): ?string
    {
        return $this->Date_de_Naissance;
    }

    public function setDateDeNaissance(string $Date_de_Naissance): self
    {
        $this->Date_de_Naissance = $Date_de_Naissance;

        return $this;
    }

    public function getBourse(): ?string
    {
        return $this->Bourse;
    }

    public function setBourse(?string $Bourse): self
    {
        $this->Bourse = $Bourse;

        return $this;
    }

    public function getTypeEtudiant(): ?string
    {
        return $this->Type_Etudiant;
    }

    public function setTypeEtudiant(string $Type_Etudiant): self
    {
        $this->Type_Etudiant = $Type_Etudiant;

        return $this;
    }

    public function getChambre(): ?Chambre
    {
        return $this->Chambre;
    }

    public function setChambre(?Chambre $Chambre): self
    {
        $this->Chambre = $Chambre;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
