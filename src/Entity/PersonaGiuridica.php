<?php

namespace App\Entity;

use App\Repository\PersonaGiuridicaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonaGiuridicaRepository::class)]
#[ORM\Table(name: 'persone_giuridiche')]
class PersonaGiuridica
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ragioneSociale = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $pIva = null;

    #[ORM\Column(length: 255)]
    private ?string $classificazione = null;

    #[ORM\OneToMany(mappedBy: 'personaGiuridica', targetEntity: Sede::class, orphanRemoval: false)]
    private Collection $sede;

    #[ORM\OneToMany(mappedBy: 'personaGiuridica', targetEntity: Utente::class)]
    private Collection $utente;

    public function __construct()
    {
        $this->sede = new ArrayCollection();
        $this->utente = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRagioneSociale(): ?string
    {
        return $this->ragioneSociale;
    }

    public function setRagioneSociale(string $ragioneSociale): self
    {
        $this->ragioneSociale = $ragioneSociale;

        return $this;
    }

    public function getPIva(): ?string
    {
        return $this->pIva;
    }

    public function setPIva(string $pIva): self
    {
        $this->pIva = $pIva;

        return $this;
    }

    public function getClassificazione(): ?string
    {
        return $this->classificazione;
    }

    public function setClassificazione(string $classificazione): self
    {
        $this->classificazione = $classificazione;

        return $this;
    }

    /**
     * @return Collection<int, Sede>
     */
    public function getSede(): Collection
    {
        return $this->sede;
    }

    public function addSede(Sede $sede): self
    {
        if (!$this->sede->contains($sede)) {
            $this->sede->add($sede);
            $sede->setPersonaGiuridica($this);
        }

        return $this;
    }

    public function removeSede(Sede $sede): self
    {
        if ($this->sede->removeElement($sede)) {
            // set the owning side to null (unless already changed)
            if ($sede->getPersonaGiuridica() === $this) {
                $sede->setPersonaGiuridica(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Utente>
     */
    public function getUtente(): Collection
    {
        return $this->utente;
    }

    public function addUtente(Utente $utente): self
    {
        if (!$this->utente->contains($utente)) {
            $this->utente->add($utente);
            $utente->setPersonaGiuridica($this);
        }

        return $this;
    }

    public function removeUtente(Utente $utente): self
    {
        if ($this->utente->removeElement($utente)) {
            // set the owning side to null (unless already changed)
            if ($utente->getPersonaGiuridica() === $this) {
                $utente->setPersonaGiuridica(null);
            }
        }

        return $this;
    }
    public function __toString():string
    {
        return $this->getRagioneSociale().$this->getPIva();
    }
}
