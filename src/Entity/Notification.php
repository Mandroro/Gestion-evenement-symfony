<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $message = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $sent_date = null;

    /**
     * @var Collection<int, Evenement>
     */
    #[ORM\OneToMany(targetEntity: Evenement::class, mappedBy: 'notification', orphanRemoval: true)]
    private Collection $evenement_id;

    public function __construct()
    {
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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getSentDate(): ?\DateTimeInterface
    {
        return $this->sent_date;
    }

    public function setSentDate(\DateTimeInterface $sent_date): static
    {
        $this->sent_date = $sent_date;

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
            $evenementId->setNotification($this);
        }

        return $this;
    }

    public function removeEvenementId(Evenement $evenementId): static
    {
        if ($this->evenement_id->removeElement($evenementId)) {
            // set the owning side to null (unless already changed)
            if ($evenementId->getNotification() === $this) {
                $evenementId->setNotification(null);
            }
        }

        return $this;
    }
}
