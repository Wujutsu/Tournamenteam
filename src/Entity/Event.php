<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $observation;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="event", orphanRemoval=true)
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity=UsersEvent::class, mappedBy="event", orphanRemoval=true)
     */
    private $usersEvents;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=GamesEvent::class, mappedBy="event", orphanRemoval=true)
     */
    private $gamesEvents;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->comment = new ArrayCollection();
        $this->usersEvents = new ArrayCollection();
        $this->gamesEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment[] = $comment;
            $comment->setEvent($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getEvent() === $this) {
                $comment->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UsersEvent[]
     */
    public function getUsersEvents(): Collection
    {
        return $this->usersEvents;
    }

    public function addUsersEvent(UsersEvent $usersEvent): self
    {
        if (!$this->usersEvents->contains($usersEvent)) {
            $this->usersEvents[] = $usersEvent;
            $usersEvent->setEvent($this);
        }

        return $this;
    }

    public function removeUsersEvent(UsersEvent $usersEvent): self
    {
        if ($this->usersEvents->removeElement($usersEvent)) {
            // set the owning side to null (unless already changed)
            if ($usersEvent->getEvent() === $this) {
                $usersEvent->setEvent(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

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
            $gamesEvent->setEvent($this);
        }

        return $this;
    }

    public function removeGamesEvent(GamesEvent $gamesEvent): self
    {
        if ($this->gamesEvents->removeElement($gamesEvent)) {
            // set the owning side to null (unless already changed)
            if ($gamesEvent->getEvent() === $this) {
                $gamesEvent->setEvent(null);
            }
        }

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }
}
