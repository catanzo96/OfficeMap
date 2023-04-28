<?php

namespace App\Entity\Model;

use App\Entity\Utente;
use App\Enum\StatoWorkflow;
use Doctrine\Common\Annotations\Annotation\Enum;

class UtenteModel
{
    public ?int $id;
    public ?string $nome;
    public ?string $cognome;
    public ?string $email;
    public ?string $ragioneSociale;
    public ?string $descrizione;
    public ?string $stato;
    public function __construct(Utente $utente)
    {
        $this->id = $utente->getId();
        $this->nome = $utente->getPersonaFisica()->getNome();
        $this->cognome = $utente->getPersonaFisica()->getCognome();
        $this->email = $utente->getEmail();
        $this->ragioneSociale = $utente->getPersonaGiuridica()?->getRagioneSociale();
        $this->descrizione = $utente->getRuolo()->getDescrizione();
        $this->stato = StatoWorkflow::from($utente->getStato())->name;
    }
}