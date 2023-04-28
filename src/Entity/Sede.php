<?php

namespace App\Entity;

use App\Repository\SedeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SedeRepository::class)]
#[ORM\Table(name: 'sedi')]
class Sede
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $paese = null;

    #[ORM\Column(length: 255)]
    private ?string $citta = null;

    #[ORM\Column(length: 255)]
    private ?string $provincia = null;

    #[ORM\Column(length: 5)]
    private ?string $cap = null;

    #[ORM\Column(length: 255)]
    private ?string $via = null;

    #[ORM\Column(length: 255)]
    private ?string $civico = null;

    #[ORM\Column]
    private ?bool $isLegale = null;

    #[ORM\Column]
    private ?bool $isOperativa = null;

    #[ORM\ManyToOne(inversedBy: 'sede')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PersonaGiuridica $personaGiuridica = null;

    // #[ORM\OneToMany(mappedBy: 'sede', targetEntity: Postazione::class, orphanRemoval: false)]
    // private Collection $postazione;

    #[ORM\OneToMany(mappedBy: 'sede', targetEntity: Stanza::class, orphanRemoval: false)]
    private Collection $stanza;

    public function __construct()
    {
        //$this->postazione = new ArrayCollection();
        $this->stanza = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaese(): ?string
    {
        return $this->paese;
    }

    public function setPaese(string $paese): self
    {
        $this->paese = $paese;

        return $this;
    }

    public function getCitta(): ?string
    {
        return $this->citta;
    }

    public function setCitta(string $citta): self
    {
        $this->citta = $citta;

        return $this;
    }

    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    public function setProvincia(string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getCap(): ?string
    {
        return $this->cap;
    }

    public function setCap(string $cap): self
    {
        $this->cap = $cap;

        return $this;
    }

    public function getVia(): ?string
    {
        return $this->via;
    }

    public function setVia(string $via): self
    {
        $this->via = $via;

        return $this;
    }

    public function getCivico(): ?string
    {
        return $this->civico;
    }

    public function setCivico(string $civico): self
    {
        $this->civico = $civico;

        return $this;
    }

    public function isIsLegale(): ?bool
    {
        return $this->isLegale;
    }

    public function setIsLegale(bool $isLegale): self
    {
        $this->isLegale = $isLegale;

        return $this;
    }

    public function isIsOperativa(): ?bool
    {
        return $this->isOperativa;
    }

    public function setIsOperativa(bool $isOperativa): self
    {
        $this->isOperativa = $isOperativa;

        return $this;
    }

    public function getPersonaGiuridica(): ?PersonaGiuridica
    {
        return $this->personaGiuridica;
    }

    public function setPersonaGiuridica(?PersonaGiuridica $personaGiuridica): self
    {
        $this->personaGiuridica = $personaGiuridica;

        return $this;
    }


    /**
     * @return Collection<int, Stanza>
     */
    public function getStanza(): Collection
    {
        return $this->stanza;
    }

    public function addStanza(Stanza $stanza): self
    {
        if (!$this->stanza->contains($stanza)) {
            $this->stanza->add($stanza);
            $stanza->setSede($this);
        }

        return $this;
    }

    public function removeStanza(Stanza $stanza): self
    {
        if ($this->stanza->removeElement($stanza)) {
            // set the owning side to null (unless already changed)
            if ($stanza->getSede() === $this) {
                $stanza->setSede(null);
            }
        }

        return $this;
    }
}
