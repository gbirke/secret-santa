<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DonorRepository")
 */
class Donor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $submitted;

    /**
     * @ORM\Column(type="boolean")
     */
    private $knowsReceiver;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $accessCode;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function hasSubmitted(): ?bool
    {
        return $this->submitted;
    }

    public function setSubmitted(bool $submitted): self
    {
        $this->submitted = $submitted;

        return $this;
    }

    public function getKnowsReceiver(): ?bool
    {
        return $this->knowsReceiver;
    }

    public function setKnowsReceiver(bool $knowsReceiver): self
    {
        $this->knowsReceiver = $knowsReceiver;

        return $this;
    }

    public function getAccessCode(): ?string
    {
        return $this->accessCode;
    }

    public function setAccessCode(string $accessCode): self
    {
        $this->accessCode = $accessCode;

        return $this;
    }
}
