<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $registration_date = null;

    /**
     * @var Collection<int, participant>
     */
    #[ORM\OneToMany(targetEntity: participant::class, mappedBy: 'inscription', orphanRemoval: true)]
    private Collection $participant_id;

    /**
     * @var Collection<int, Evenement>
     */
    #[ORM\OneToMany(targetEntity: Evenement::class, mappedBy: 'inscription', orphanRemoval: true)]
    private Collection $evenement_id;

    public function __construct()
    {
        $this->participant_id = new ArrayCollection();
        $this->evenement_id = new ArrayCollection();
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

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registration_date;
    }

    public function setRegistrationDate(\DateTimeInterface $registration_date): static
    {
        $this->registration_date = $registration_date;

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
            $participantId->setInscription($this);
        }

        return $this;
    }

    public function removeParticipantId(participant $participantId): static
    {
        if ($this->participant_id->removeElement($participantId)) {
            // set the owning side to null (unless already changed)
            if ($participantId->getInscription() === $this) {
                $participantId->setInscription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenementId(): Collection
    {
        return $this->evenement_id;
    }

    public function addEvenementId(Evenement $evenementId): static
    {
        if (!$this->evenement_id->contains($evenementId)) {
            $this->evenement_id->add($evenementId);
            $evenementId->setInscription($this);
        }

        return $this;
    }

    public function removeEvenementId(Evenement $evenementId): static
    {
        if ($this->evenement_id->removeElement($evenementId)) {
            // set the owning side to null (unless already changed)
            if ($evenementId->getInscription() === $this) {
                $evenementId->setInscription(null);
            }
        }

        return $this;
    }
}
