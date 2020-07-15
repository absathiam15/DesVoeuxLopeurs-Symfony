<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChambreRepository::class)
 */
class Chambre
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
    private $num_chambre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=batiment::class, inversedBy="chambres")
     */
    private $num_batiment;

    /**
     * @ORM\OneToMany(targetEntity=Etudiant::class, mappedBy="chambre")
     */
    private $etudiants;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumChambre(): ?string
    {
        return $this->num_chambre;
    }

    public function setNumChambre(string $num_chambre): self
    {
        $this->num_chambre = $num_chambre;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNumBatiment(): ?batiment
    {
        return $this->num_batiment;
    }

    public function setNumBatiment(?batiment $num_batiment): self
    {
        $this->num_batiment = $num_batiment;

        return $this;
    }

    /**
     * @return Collection|Etudiant[]
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setChambre($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->contains($etudiant)) {
            $this->etudiants->removeElement($etudiant);
            // set the owning side to null (unless already changed)
            if ($etudiant->getChambre() === $this) {
                $etudiant->setChambre(null);
            }
        }

        return $this;
    }
    public function NumChambre(ChambreRepository $ChambreRepository){
        $num = $ChambreRepository->FindAll();
        $num = $num[count($num)-1]->id+1;
        if($num < 10){
            $num = "000".$num;
        }else{
            if($num < 100){
                $num = "00".$num;
            }else{
                if($num < 1000){
                    $num = "0".$num;
                }
            }
        }
        return $num;
    }
}
