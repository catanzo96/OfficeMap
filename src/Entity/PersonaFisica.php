<?php

namespace App\Entity;

use App\Repository\PersonaFisicaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonaFisicaRepository::class)]
#[ORM\Table(name: 'persone_fisiche')]
class PersonaFisica
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255)]
    private ?string $cognome = null;

    #[ORM\Column(length: 16, unique: true)]
    private ?string $cf = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dataNascita = null;

    #[ORM\Column(length: 255)]
    private ?string $luogoNascita = null;

    #[ORM\Column(length: 255)]
    private ?string $provinciaNascita = null;

    #[ORM\OneToMany(mappedBy: 'personaFisica', targetEntity: Utente::class)]
    private Collection $utente;

    public function __construct()
    {
        $this->utente = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCognome(): ?string
    {
        return $this->cognome;
    }

    public function setCognome(string $cognome): self
    {
        $this->cognome = $cognome;

        return $this;
    }

    public function getCf(): ?string
    {
        return $this->cf;
    }

    public function setCf(string $cf): self
    {
        $this->cf = $cf;

        return $this;
    }

    public function getDataNascita(): ?\DateTimeInterface
    {
        return $this->dataNascita;
    }

    public function setDataNascita(\DateTimeInterface $dataNascita): self
    {
        $this->dataNascita = $dataNascita;

        return $this;
    }

    public function getLuogoNascita(): ?string
    {
        return $this->luogoNascita;
    }

    public function setLuogoNascita(string $luogoNascita): self
    {
        $this->luogoNascita = $luogoNascita;

        return $this;
    }

    public function getProvinciaNascita(): ?string
    {
        return $this->provinciaNascita;
    }

    public function setProvinciaNascita(string $provinciaNascita): self
    {
        $this->provinciaNascita = $provinciaNascita;

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
            $utente->setPersonaFisica($this);
        }

        return $this;
    }

    public function removeUtente(Utente $utente): self
    {
        if ($this->utente->removeElement($utente)) {
            // set the owning side to null (unless already changed)
            if ($utente->getPersonaFisica() === $this) {
                $utente->setPersonaFisica(null);
            }
        }

        return $this;
    }
    public function __toString():string
    {
        return $this->getNome().$this->getCognome();
    }
}
