<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

// Ajout route personalisé ici (reservationid) car pas possible à un autre endroit visiblement.
/**
 * @ORM\Entity(repositoryClass=ReservationsRepository::class)
 * @ApiResource(
 * normalizationContext={"groups"={"reservations:collection"}},
 *      denormalizationContext={"groups"={"reservations:write"}},
 *      paginationItemsPerPage= 20,
 *      paginationMaximumItemsPerPage= 20,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},      
 *          },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"reservations:collection", "reservations:item"}}},
 *          "put"={},
 *          "delete"={},
 *               "Dashboard/user/reservations/{id}"={
 *                  "method"="GET",
 *                  "path"="Dashboard/user/reservations/{id}",
 *                  "force_eager"=false,
 *                  "normalization_context"={"groups"={"reservations:user", "reserv:user"}}
 *                 },
 *          })
 */
class Reservations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"reservations:collection", "comments:item", "read:reservperso", "properties:item", "payments:item", "user:item", "user:reservations", "reservations:user", "properties:comments"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"reservations:collection", "reservations:user", "comments:item", "read:reservperso", "properties:item", "payments:item", "user:item", "user:reservations", "read:reservations", "properties:comments"})
     */
    private $start_date;

    /**
     * @ORM\Column(type="date")
     * @Groups({"reservations:collection", "reservations:user", "comments:item", "read:reservperso", "properties:item", "payments:item", "user:item", "user:reservations", "read:reservations"})
     */
    private $end_date;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"reservations:item", "properties:item", "reservations:user", "user:item"})
     */
    private $is_approuved;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"reservations:item", "properties:item", "user:item", "reservations:user", "read:reservperso"})
     */
    private $is_cancelled;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"reservations:item", "properties:item", "user:item", "reservations:user"})
     */
    private $is_paid;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"reservations:item", "properties:item", "user:item", "reservations:user"})
     */
    private $participants_nbr;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"reservations:item", "properties:item", "user:item", "reservations:user"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"reservations:item", "properties:item", "user:item", "reservations:user"})
     */
    private $updated_at;    

    /**
     * @ORM\OneToOne(targetEntity=Payments::class, inversedBy="reservations", cascade={"persist", "remove"})
     * @Groups({"reservations:user"})
     */
    private $payments;

    /**
     * @ORM\ManyToOne(targetEntity=Properties::class, inversedBy="reservations")
     * @Groups({"reservations:item", "comments:item", "read:reservations", "reservations:user", "read:commentsid", "read:commentsperso"})
     */
    private $properties;

      
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservations")
     * @Groups({"reserv:user"})
     * 
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="reservations")
     * @Groups({"reservations:item", "reservations:user"})
     */
    private $comments;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartdate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $comment->setReservations($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getReservations() === $this) {
                $comment->setReservations(null);
            }
        }

        return $this;
    }
}
