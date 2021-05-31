<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = ["ROLE_PLAYER"];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Pseudo;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="users")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=UsersEvent::class, mappedBy="user", orphanRemoval=true)
     */
    private $usersEvents;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="user")
     */
    private $events;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="user", orphanRemoval=true)
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity=Convertation::class, mappedBy="user", orphanRemoval=true)
     */
    private $convertations;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->usersEvents = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->convertations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->Pseudo;
    }

    public function setPseudo(string $Pseudo): self
    {
        $this->Pseudo = $Pseudo;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUsers($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUsers() === $this) {
                $comment->setUsers(null);
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
            $usersEvent->setUser($this);
        }

        return $this;
    }

    public function removeUsersEvent(UsersEvent $usersEvent): self
    {
        if ($this->usersEvents->removeElement($usersEvent)) {
            // set the owning side to null (unless already changed)
            if ($usersEvent->getUser() === $this) {
                $usersEvent->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setUser($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getUser() === $this) {
                $event->setUser(null);
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
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setUser($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getUser() === $this) {
                $contact->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Convertation[]
     */
    public function getConvertations(): Collection
    {
        return $this->convertations;
    }

    public function addConvertation(Convertation $convertation): self
    {
        if (!$this->convertations->contains($convertation)) {
            $this->convertations[] = $convertation;
            $convertation->setUser($this);
        }

        return $this;
    }

    public function removeConvertation(Convertation $convertation): self
    {
        if ($this->convertations->removeElement($convertation)) {
            // set the owning side to null (unless already changed)
            if ($convertation->getUser() === $this) {
                $convertation->setUser(null);
            }
        }

        return $this;
    }
}
