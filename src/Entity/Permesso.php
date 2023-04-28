<?php

namespace App\Entity;

use App\Repository\PermessoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermessoRepository::class)]
#[ORM\Table(name: 'permessi')]
class Permesso
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'permessi', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ruolo $ruolo = null;

    #[ORM\Column (options: ['default' => false])]
    private ?bool $gestionePrenotazione = false;

    #[ORM\Column (options: ['default' => false])]
    private ?bool $gestioneUtenti = false;

    #[ORM\Column (options: ['default' => false])]
    private ?bool $gestioneStanze = false;

    #[ORM\Column (options: ['default' => false])]
    private ?bool $richiestaPrenotazione = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRuolo(): ?Ruolo
    {
        return $this->ruolo;
    }

    public function setRuolo(Ruolo $ruolo): self
    {
        $this->ruolo = $ruolo;

        return $this;
    }

    public function isGestionePrenotazione(): ?bool
    {
        return $this->gestionePrenotazione;
    }

    public function setGestionePrenotazione(bool $gestionePrenotazione): self
    {
        $this->gestionePrenotazione = $gestionePrenotazione;

        return $this;
    }

    public function isGestioneUtenti(): ?bool
    {
        return $this->gestioneUtenti;
    }

    public function setGestioneUtenti(bool $gestioneUtenti): self
    {
        $this->gestioneUtenti = $gestioneUtenti;

        return $this;
    }

    public function isGestioneStanze(): ?bool
    {
        return $this->gestioneStanze;
    }

    public function setGestioneStanze(bool $gestioneStanze): self
    {
        $this->gestioneStanze = $gestioneStanze;

        return $this;
    }

    public function isRichiestaPrenotazione(): ?bool
    {
        return $this->richiestaPrenotazione;
    }

    public function setRichiestaPrenotazione(bool $richiestaPrenotazione): self
    {
        $this->richiestaPrenotazione = $richiestaPrenotazione;

        return $this;
    }
}
