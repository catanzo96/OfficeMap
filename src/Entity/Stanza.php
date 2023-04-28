<?php

namespace App\Entity;

use App\Repository\StanzaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StanzaRepository::class)]
class Stanza
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $piano = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\ManyToOne(inversedBy: 'stanza')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sede $sede = null;

    #[ORM\OneToMany(mappedBy: 'stanza', targetEntity: Postazione::class, orphanRemoval: true)]
    private Collection $postazione;

    public function __construct()
    {
        $this->postazione = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPiano(): ?string
    {
        return $this->piano;
    }

    public function setPiano(string $piano): self
    {
        $this->piano = $piano;

        return $this;
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

    public function getSede(): ?Sede
    {
        return $this->sede;
    }

    public function setSede(?Sede $sede): self
    {
        $this->sede = $sede;

        return $this;
    }

    /**
     * @return Collection<int, Postazione>
     */
    public function getPostazione(): Collection
    {
        return $this->postazione;
    }

    public function addPostazione(Postazione $postazione): self
    {
        if (!$this->postazione->contains($postazione)) {
            $this->postazione->add($postazione);
            $postazione->setStanza($this);
        }

        return $this;
    }

    public function removePostazione(Postazione $postazione): self
    {
        if ($this->postazione->removeElement($postazione)) {
            // set the owning side to null (unless already changed)
            if ($postazione->getStanza() === $this) {
                $postazione->setStanza(null);
            }
        }

        return $this;
    }
}
