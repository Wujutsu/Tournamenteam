<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="contacts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="contacts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    /**
     * @ORM\OneToMany(targetEntity=Convertation::class, mappedBy="contact", orphanRemoval=true)
     */
    private $convertations;

    /**
     * @ORM\Column(type="integer")
     * 0=demande envoyée // 1=attente validation // 1=demande acceptée
     */
    private $accept;

    public function __construct()
    {
        $this->convertations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContact(): ?Users
    {
        return $this->contact;
    }

    public function setContact(?Users $contact): self
    {
        $this->contact = $contact;

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
            $convertation->setContact($this);
        }

        return $this;
    }

    public function removeConvertation(Convertation $convertation): self
    {
        if ($this->convertations->removeElement($convertation)) {
            // set the owning side to null (unless already changed)
            if ($convertation->getContact() === $this) {
                $convertation->setContact(null);
            }
        }

        return $this;
    }

    public function getAccept(): ?int
    {
        return $this->accept;
    }

    public function setAccept(int $accept): self
    {
        $this->accept = $accept;

        return $this;
    }

}
