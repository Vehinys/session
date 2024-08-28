<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $start_session = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $end_session = null;

    #[ORM\Column]
    private ?int $nb_places = null;

    #[ORM\Column]
    private ?int $nb_places_reserved = null;

    /**
     * @var Collection<int, Trainee>
     */
    #[ORM\ManyToMany(targetEntity: Trainee::class, mappedBy: 'sessions')]
    private Collection $trainees;

    /**
     * @var Collection<int, Programme>
     */
    #[ORM\ManyToMany(targetEntity: Programme::class, mappedBy: 'sessions')]
    private Collection $programmes;

    public function __construct()
    {
        $this->trainees = new ArrayCollection();
        $this->programmes = new ArrayCollection();

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStartSession(): ?\DateTimeImmutable
    {
        return $this->start_session;
    }

    public function setStartSession(\DateTimeImmutable $start_session): static
    {
        $this->start_session = $start_session;

        return $this;
    }

    public function getEndSession(): ?\DateTimeImmutable
    {
        return $this->end_session;
    }

    public function setEndSession(\DateTimeImmutable $end_session): static
    {
        $this->end_session = $end_session;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nb_places;
    }

    public function setNbPlaces(int $nb_places): static
    {
        $this->nb_places = $nb_places;

        return $this;
    }

    public function getNbPlacesReserved(): ?int
    {
        return $this->nb_places_reserved;
    }

    public function setNbPlacesReserved(int $nb_places_reserved): static
    {
        $this->nb_places_reserved = $nb_places_reserved;

        return $this;
    }

    /**
     * @return Collection<int, Trainee>
     */
    public function getTrainees(): Collection
    {
        return $this->trainees;
    }

    public function addTrainee(Trainee $trainee): static
    {
        if (!$this->trainees->contains($trainee)) {
            $this->trainees->add($trainee);
            $trainee->addSession($this);
        }

        return $this;
    }

    public function removeTrainee(Trainee $trainee): static
    {
        if ($this->trainees->removeElement($trainee)) {
            $trainee->removeSession($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programme $programme): static
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes->add($programme);
            $programme->addSession($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): static
    {
        if ($this->programmes->removeElement($programme)) {
            $programme->removeSession($this);
        }

        return $this;
    }

}
