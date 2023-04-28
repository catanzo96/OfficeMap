<?php

namespace App\Entity;

use App\Entity\Model\UtenteModel;
use App\Enum\StatoWorkflow;
use App\Repository\UtenteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtenteRepository::class)]
#[ORM\Table(name: 'utenti')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Utente implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $telefono = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $stato = null;

    #[ORM\ManyToOne(inversedBy: 'utente')]
    #[ORM\JoinColumn(nullable: false)]
//    #[ORM\OneToMany(mappedBy: 'utente', targetEntity: Ruolo::class, orphanRemoval: false)]
    private ?Ruolo $ruolo = null;

    #[ORM\ManyToOne(inversedBy: 'utente')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PersonaFisica $personaFisica = null;

    #[ORM\ManyToOne(inversedBy: 'utente')]
    #[ORM\JoinColumn(nullable: true)]
    private ?PersonaGiuridica $personaGiuridica = null;

    #[ORM\OneToMany(mappedBy: 'utente', targetEntity: Prenotazione::class)]
    private Collection $prenotazione;

    #[ORM\Column(length: 255)]
    private ?string $passwordPrecedente = null;

    public function __construct()
    {
        $this->prenotazione = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getStato(): ?string
    {
        return $this->stato;
    }

    public function setStato(string $stato): self
    {
        $this->stato = $stato;
        return $this;
    }

       public function getRuolo(): ?Ruolo
       {
        return $this->ruolo;
        }


    public function setRuolo(?Ruolo $ruolo): self
    {
        $this->ruolo = $ruolo;
        return $this;
    }

    public function getPersonaFisica(): ?PersonaFisica
    {
        return $this->personaFisica;
    }

    public function setPersonaFisica(?PersonaFisica $personaFisica): self
    {
        $this->personaFisica = $personaFisica;
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
     * @return Collection<int, Prenotazione>
     */
    public function getPrenotazione(): Collection
    {
        return $this->prenotazione;
    }

    public function addPrenotazione(Prenotazione $prenotazione): self
    {
        if (!$this->prenotazione->contains($prenotazione)) {
            $this->prenotazione->add($prenotazione);
            $prenotazione->setUtente($this);
        }
        return $this;
    }

    public function removePrenotazione(Prenotazione $prenotazione): self
    {
        if ($this->prenotazione->removeElement($prenotazione)) {
            // set the owning side to null (unless already changed)
            if ($prenotazione->getUtente() === $this) {
                $prenotazione->setUtente(null);
            }
        }
        return $this;
    }

    public function getPasswordPrecedente(): ?string
    {
        return $this->passwordPrecedente;
    }

    public function setPasswordPrecedente(string $passwordPrecedente): self
    {
        $this->passwordPrecedente = $passwordPrecedente;
        return $this;
    }


//////////////////////////////////////////////////////// SICUREZZA
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getRoles(): array
    {
        //$ruolo[] = 'ROLE_GUEST';
        $ruolo[] = $this->ruolo->getCodice();

        return array_unique($ruolo);
    }

    public function __toString(): string
    {
        return '(' . $this->getRuolo() . ')' . $this->getPersonaFisica() . '|' . $this->getPersonaGiuridica();
    }

    public function getDTO(): UtenteModel
    {
        return new UtenteModel($this);
    }
}
