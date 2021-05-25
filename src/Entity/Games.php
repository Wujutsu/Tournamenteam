<?php

namespace App\Entity;

use App\Repository\GamesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GamesRepository::class)
 */
class Games
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name_img;

    /**
     * @ORM\OneToMany(targetEntity=GamesEvent::class, mappedBy="game", orphanRemoval=true)
     */
    private $gamesEvents;

    public function __construct()
    {
        $this->gamesEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNameImg(): ?string
    {
        return $this->name_img;
    }

    public function setNameImg(string $name_img): self
    {
        $this->name_img = $name_img;

        return $this;
    }

    /**
     * @return Collection|GamesEvent[]
     */
    public function getGamesEvents(): Collection
    {
        return $this->gamesEvents;
    }

    public function addGamesEvent(GamesEvent $gamesEvent): self
    {
        if (!$this->gamesEvents->contains($gamesEvent)) {
            $this->gamesEvents[] = $gamesEvent;
            $gamesEvent->setGame($this);
        }

        return $this;
    }

    public function removeGamesEvent(GamesEvent $gamesEvent): self
    {
        if ($this->gamesEvents->removeElement($gamesEvent)) {
            // set the owning side to null (unless already changed)
            if ($gamesEvent->getGame() === $this) {
                $gamesEvent->setGame(null);
            }
        }

        return $this;
    }
}
