<?php

namespace App\Entity;

use App\Repository\RuoloRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RuoloRepository::class)]
#[ORM\Table(name: 'ruoli')]
class Ruolo
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $descrizione = null;

    #[ORM\Column]
    private ?int $stato = null;

    #[ORM\OneToOne(mappedBy: 'ruolo', cascade: ['persist', 'remove'])]
    private ?Permesso $permessi = null;

    #[ORM\Column(length: 255)]
    private ?string $codice = null;

    #[ORM\Column(length: 255)]
    private ?string $defaultRoute = null;

    #[ORM\OneToMany(mappedBy: 'ruolo', targetEntity: Utente::class, orphanRemoval: false)]
//    #[ORM\ManyToOne(inversedBy: 'ruolo')]
//    #[ORM\JoinColumn(nullable: false)]
    private Collection $utente;


    public function __construct()
    {
        $this->utente = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescrizione(): ?string
    {
        return $this->descrizione;
    }

    public function setDescrizione(string $descrizione): self
    {
        $this->descrizione = $descrizione;

        return $this;
    }

    public function getStato(): ?int
    {
        return $this->stato;
    }

    public function setStato(int $stato): self
    {
        $this->stato = $stato;

        return $this;
    }

    public function getPermessi(): ?Permesso
    {
        return $this->permessi;
    }

    public function setPermessi(Permesso $permessi): self
    {
        // set the owning side of the relation if necessary
        if ($permessi->getRuolo() !== $this) {
            $permessi->setRuolo($this);
        }

        $this->permessi = $permessi;

        return $this;
    }

    public function getCodice(): ?string
    {
        return $this->codice;
    }

    public function setCodice(string $codice): self
    {
        $this->codice = $codice;

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
            $utente->setRuolo($this);
        }

        return $this;
    }

    public function removeUtente(Utente $utente): self
    {
        if ($this->utente->removeElement($utente)) {
            // set the owning side to null (unless already changed)
            if ($utente->getRuolo() === $this) {
                $utente->setRuolo(null);
            }
        }

        return $this;
    }

    public function getDefaultRoute(): ?string
    {
        return $this->defaultRoute;
    }

    public function setDefaultRoute(string $defaultRoute): self
    {
        $this->defaultRoute = $defaultRoute;

        return $this;
    }

    public function __toString():string
    {
        return $this->getDescrizione();
    }
    public function getIdFromCodice(string $codice): int
    {

        return $this->getIdFromCodice($codice);
    }

}
