<?php

namespace App\Entity;

use App\Repository\StatistiqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatistiqueRepository::class)]
class Statistique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $total_participants = null;

    #[ORM\Column]
    private ?int $total_revenue = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evenement $evenement_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTotalParticipants(): ?int
    {
        return $this->total_participants;
    }

    public function setTotalParticipants(int $total_participants): static
    {
        $this->total_participants = $total_participants;

        return $this;
    }

    public function getTotalRevenue(): ?int
    {
        return $this->total_revenue;
    }

    public function setTotalRevenue(int $total_revenue): static
    {
        $this->total_revenue = $total_revenue;

        return $this;
    }

    public function getEvenementId(): ?Evenement
    {
        return $this->evenement_id;
    }

    public function setEvenementId(Evenement $evenement_id): static
    {
        $this->evenement_id = $evenement_id;

        return $this;
    }
}
