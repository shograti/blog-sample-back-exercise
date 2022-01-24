<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass= "App\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_categorie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle_categorie", type="string", length=100, nullable=false)
     */
    private $libelleCategorie;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Article", mappedBy="idCategorie")
     */
    private $idArticle;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idArticle = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }

    public function getLibelleCategorie(): ?string
    {
        return $this->libelleCategorie;
    }

    public function setLibelleCategorie(string $libelleCategorie): self
    {
        $this->libelleCategorie = $libelleCategorie;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getIdArticle(): Collection
    {
        return $this->idArticle;
    }

    public function addIdArticle(Article $idArticle): self
    {
        if (!$this->idArticle->contains($idArticle)) {
            $this->idArticle[] = $idArticle;
            $idArticle->addIdCategorie($this);
        }

        return $this;
    }

    public function removeIdArticle(Article $idArticle): self
    {
        if ($this->idArticle->removeElement($idArticle)) {
            $idArticle->removeIdCategorie($this);
        }

        return $this;
    }

}
