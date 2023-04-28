<?php

namespace App\Entity;

use App\Repository\PostazioneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostazioneRepository::class)]
#[ORM\Table(name: 'postazioni')]
class Postazione
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $hasMonitor = null;

    #[ORM\Column]
    private ?bool $hasTastiera = null;

    #[ORM\Column]
    private ?bool $hasMouse = null;

    #[ORM\Column(nullable: true)]
    private ?float $cordinataX = null;

    #[ORM\Column(nullable: true)]
    private ?float $cordinataY = null;

    #[ORM\ManyToOne(inversedBy: 'postazione')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stanza $stanza = null;

    #[ORM\OneToMany(mappedBy: 'postazione', targetEntity: Prenotazione::class)]
    private Collection $prenotazione;

    public function __construct()
    {
        $this->prenotazione = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isHasMonitor(): ?bool
    {
        return $this->hasMonitor;
    }

    public function setHasMonitor(bool $hasMonitor): self
    {
        $this->hasMonitor = $hasMonitor;

        return $this;
    }

    public function isHasTastiera(): ?bool
    {
        return $this->hasTastiera;
    }

    public function setHasTastiera(bool $hasTastiera): self
    {
        $this->hasTastiera = $hasTastiera;

        return $this;
    }

    public function isHasMouse(): ?bool
    {
        return $this->hasMouse;
    }

    public function setHasMouse(bool $hasMouse): self
    {
        $this->hasMouse = $hasMouse;

        return $this;
    }

    public function getCordinataX(): ?float
    {
        return $this->cordinataX;
    }

    public function setCordinataX(?float $cordinataX): self
    {
        $this->cordinataX = $cordinataX;

        return $this;
    }

    public function getCordinataY(): ?float
    {
        return $this->cordinataY;
    }

    public function setCordinataY(?float $cordinataY): self
    {
        $this->cordinataY = $cordinataY;

        return $this;
    }

    public function getStanza(): ?Stanza
    {
        return $this->stanza;
    }

    public function setStanza(?Stanza $stanza): self
    {
        $this->stanza = $stanza;

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
            $prenotazione->setPostazione($this);
        }

        return $this;
    }

    public function removePrenotazione(Prenotazione $prenotazione): self
    {
        if ($this->prenotazione->removeElement($prenotazione)) {
            // set the owning side to null (unless already changed)
            if ($prenotazione->getPostazione() === $this) {
                $prenotazione->setPostazione(null);
            }
        }

        return $this;
    }
}
