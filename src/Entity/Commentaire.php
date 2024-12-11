<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_commentaire = null;

    #[ORM\Column(length: 255)]
    private ?string $auteur = null;

    /**
     * @var Collection<int, evenement>
     */
    #[ORM\OneToMany(targetEntity: evenement::class, mappedBy: 'commentaire', orphanRemoval: true)]
    private Collection $evenement_id;

    /**
     * @var Collection<int, participant>
     */
    #[ORM\OneToMany(targetEntity: participant::class, mappedBy: 'commentaire', orphanRemoval: true)]
    private Collection $participant_id;

    public function __construct()
    {
        $this->evenement_id = new ArrayCollection();
        $this->participant_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateCommentaire(): ?\DateTimeInterface
    {
        return $this->date_commentaire;
    }

    public function setDateCommentaire(\DateTimeInterface $date_commentaire): static
    {
        $this->date_commentaire = $date_commentaire;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * @return Collection<int, evenement>
     */
    public function getEvenementId(): Collection
    {
        return $this->evenement_id;
    }

    public function addEvenementId(evenement $evenementId): static
    {
        if (!$this->evenement_id->contains($evenementId)) {
            $this->evenement_id->add($evenementId);
            $evenementId->setCommentaire($this);
        }

        return $this;
    }

    public function removeEvenementId(evenement $evenementId): static
    {
        if ($this->evenement_id->removeElement($evenementId)) {
            // set the owning side to null (unless already changed)
            if ($evenementId->getCommentaire() === $this) {
                $evenementId->setCommentaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, participant>
     */
    public function getParticipantId(): Collection
    {
        return $this->participant_id;
    }

    public function addParticipantId(participant $participantId): static
    {
        if (!$this->participant_id->contains($participantId)) {
            $this->participant_id->add($participantId);
            $participantId->setCommentaire($this);
        }

        return $this;
    }

    public function removeParticipantId(participant $participantId): static
    {
        if ($this->participant_id->removeElement($participantId)) {
            // set the owning side to null (unless already changed)
            if ($participantId->getCommentaire() === $this) {
                $participantId->setCommentaire(null);
            }
        }

        return $this;
    }
}
