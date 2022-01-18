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
 *                   
 *                  "dashboard/admin/reservations"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/reservations",
 *                  "normalization_context"={"groups"={"admin:reservations", "enable_max_depth"=true}},
 *                  
 *               },     
 * 
 *                  "thebestproperty"={
 *                  "method"="GET",
 *                  "path"="home/bestproperty",
 *                  "controller"=App\Controller\TheBestRatedProperty::class,
 *               },   
 * 
 *          },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"reservations:collection", "reservations:item"}}},
 *          "put"={},
 *          "delete"={},
 * 
 *                  "dashboard/user/reservations/{id}"={
 *                  "method"="GET",
 *                  "path"="dashboard/user/reservations/{id}",
 *                  "force_eager"=false,
 *                  "normalization_context"={"groups"={"reservations:user", "reserv:user"}}
 *                 },
 *                 "dashboard/owner/reservations/{id}"={
 *                  "method"="GET",
 *                  "path"="dashboard/owner/reservations/{id}",
 *                  "force_eager"=false,
 *                  "normalization_context"={"groups"={"owner:reservid", "owner:read"}}
 *                 },
 *                  "dashboard/admin/reservations/{id}"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/reservations/{id}",
 *                  "force_eager"=false,
 *                  "normalization_context"={"groups"={"owner:reservid", "owner:read"}}
 *                 },
 *          }
 * )
 */
class Reservations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"reservations:collection", "admin:usersid", "propertiesid:item", "comments:item", "read:reservperso", "owner:reservations", "admin:reservations", "owner:reservid", "owner:reserv", "owner:propertiesid", "properties:item", "payments:item", "user:item", "user:reservations", "reservations:user", "properties:comments", "reservations:comments"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"reservations:collection", "admin:usersid", "propertiesid:item", "reservations:user", "comments:item", "owner:reservations", "admin:reservations", "owner:reservid","owner:reserv", "owner:propertiesid", "read:reservperso", "properties:item", "payments:item", "user:item", "user:reservations", "read:reservations", "properties:comments"})
     */
    private $start_date;

    /**
     * @ORM\Column(type="date")
     * @Groups({"reservations:collection", "admin:usersid", "propertiesid:item", "reservations:user", "comments:item", "owner:reservations", "admin:reservations", "owner:reservid", "owner:reserv", "owner:propertiesid", "read:reservperso", "properties:item", "payments:item", "user:item", "user:reservations", "read:reservations"})
     */
    private $end_date;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"reservations:item", "properties:item", "reservations:user", "user:item", "owner:reservid", "owner:propertiesid"})
     */
    private $is_approuved;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"reservations:item", "admin:usersid", "propertiesid:item", "properties:item", "user:item", "owner:reservations", "admin:reservations", "reservations:user", "owner:reservid", "read:reservperso", "owner:propertiesid", "owner:reserv"})
     */
    private $is_cancelled;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"reservations:item", "admin:usersid", "properties:item", "user:item", "reservations:user", "owner:reservid", "owner:propertiesid"})
     */
    private $is_paid;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"reservations:item", "admin:usersid", "properties:item", "user:item", "reservations:user", "owner:reservid", "owner:propertiesid"})
     */
    private $participants_nbr;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"reservations:item", "properties:item", "user:item", "reservations:user", "owner:reservid", "owner:propertiesid"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"reservations:item", "properties:item", "user:item", "reservations:user", "owner:reservid", "owner:propertiesid"})
     */
    private $updated_at;    

    /**
     * @ORM\OneToOne(targetEntity=Payments::class, inversedBy="reservations", cascade={"persist", "remove"})
     * @Groups({"reservations:user", "owner:propertiesid", "owner:reservid"})
     */
    private $payments;

    /**
     * @ORM\ManyToOne(targetEntity=Properties::class, inversedBy="reservations")
     * @Groups({"reservations:item", "admin:commentsid", "lastcomments:collection", "comments:item", "admin:comments", "read:reservations", "reservations:user", "read:commentsid", "read:commentsperso", "owner:reservid"})
     */
    private $properties;

      
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservations")
     * @Groups({"reserv:user", "owner:reserv", "owner:reservid", "admin:reserv", "propertiesid:item"})
     * 
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="reservations")
     * @Groups({"reservations:item", "propertiesid:item", "reservations:user", "owner:propertiesid", "properties:item", "properties:collection", "admin:usersid"})
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
