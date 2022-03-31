<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Cryptomonnaie;
use App\Entity\User;
/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cryptomonnaie::class, inversedBy="notes")
     */
    private $crypto;

    /**
     * @ORM\Column(type="float")
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="notes")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCrypto(): ?Cryptomonnaie
    {
        return $this->crypto;
    }

    public function setCrypto(?Cryptomonnaie $crypto): self
    {
        $this->crypto = $crypto;

        return $this;
    }

    public function getContenu(): ?float
    {
        return $this->contenu;
    }

    public function setContenu(float $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
