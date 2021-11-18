<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReservationsRepository::class)
 * @ApiResource(
 * normalizationContext={"groups"={"reservations:read"}},
 *      denormalizationContext={"groups"={"reservations:write"}},
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *                "lastnewreservations"={
 *                  "method"="GET",
 *                  "path"="reservations/lastnewreservations",
 *                  "controller"=App\Controller\LastNewReservations::class
 *          },
 *          },
 *      itemOperations={
 * 
 *          "get"={},
 *          "put"={},
 *          "delete"={},
 *          })
 */
class Reservations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"reservations:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"reservations:read"})
     */
    private $startdate;

    /**
     * @ORM\Column(type="date")
     * @Groups({"reservations:read"})
     */
    private $end_date;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"reservations:read"})
     */
    private $is_approuved;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"reservations:read"})
     */
    private $is_cancelled;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"reservations:read"})
     */
    private $is_paid;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"reservations:read"})
     */
    private $participants_nbr;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"reservations:read"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"reservations:read"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity=Comments::class, inversedBy="reservations")
     * @Groups({"reservations:read"})
     */
    private $comments;

    /**
     * @ORM\OneToOne(targetEntity=Payments::class, inversedBy="reservations", cascade={"persist", "remove"})
     */
    private $payments;

    /**
     * @ORM\ManyToOne(targetEntity=Properties::class, inversedBy="reservations")
     */
    private $properties;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTimeInterface $startdate): self
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getIsApprouved(): ?bool
    {
        return $this->is_approuved;
    }

    public function setIsApprouved(bool $is_approuved): self
    {
        $this->is_approuved = $is_approuved;

        return $this;
    }

    public function getIsCancelled(): ?bool
    {
        return $this->is_cancelled;
    }

    public function setIsCancelled(bool $is_cancelled): self
    {
        $this->is_cancelled = $is_cancelled;

        return $this;
    }

    public function getIsPaid(): ?bool
    {
        return $this->is_paid;
    }

    public function setIsPaid(bool $is_paid): self
    {
        $this->is_paid = $is_paid;

        return $this;
    }

    public function getParticipantsNbr(): ?int
    {
        return $this->participants_nbr;
    }

    public function setParticipantsNbr(int $participants_nbr): self
    {
        $this->participants_nbr = $participants_nbr;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        $this->comments->removeElement($comment);

        return $this;
    }

    public function getPayments(): ?Payments
    {
        return $this->payments;
    }

    public function setPayments(?Payments $payments): self
    {
        $this->payments = $payments;

        return $this;
    }

    public function getProperties(): ?Properties
    {
        return $this->properties;
    }

    public function setProperties(?Properties $properties): self
    {
        $this->properties = $properties;

        return $this;
    }
}
