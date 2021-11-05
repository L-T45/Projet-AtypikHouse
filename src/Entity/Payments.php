<?php

namespace App\Entity;

use App\Repository\PaymentsRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;

/**
 * @ORM\Entity(repositoryClass=PaymentsRepository::class)
 * @ApiResource()
 */
class Payments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_paidback;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paidback_state;

    /**
     * @ORM\OneToOne(targetEntity=Reservations::class, mappedBy="payments", cascade={"persist", "remove"})
     */
    private $reservations;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function __construct()
    {
        
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getIsPaidback(): ?bool
    {
        return $this->is_paidback;
    }

    public function setIsPaidback(bool $is_paidback): self
    {
        $this->is_paidback = $is_paidback;

        return $this;
    }

    public function getPaidbackState(): ?string
    {
        return $this->paidback_state;
    }

    public function setPaidbackState(?string $paidback_state): self
    {
        $this->paidback_state = $paidback_state;

        return $this;
    }

    public function getReservations(): ?Reservations
    {
        return $this->reservations;
    }

    public function setReservations(?Reservations $reservations): self
    {
        // unset the owning side of the relation if necessary
        if ($reservations === null && $this->reservations !== null) {
            $this->reservations->setPayments(null);
        }

        // set the owning side of the relation if necessary
        if ($reservations !== null && $reservations->getPayments() !== $this) {
            $reservations->setPayments($this);
        }

        $this->reservations = $reservations;

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
}
