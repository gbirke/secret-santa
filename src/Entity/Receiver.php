<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReceiverRepository")
 */
class Receiver
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Donor", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $donor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDonor(): ?Donor
    {
        return $this->donor;
    }

    public function setDonor(Donor $donor): self
    {
        $this->donor = $donor;

        return $this;
    }
}
