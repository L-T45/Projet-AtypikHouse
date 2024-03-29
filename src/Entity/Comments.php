<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

// Ajout route personalisé ici ("properties_{id}_comments") car pas possible à un autre endroit visiblement.
/**
 * @ORM\Entity(repositoryClass=CommentsRepository::class)
 * @ApiResource( normalizationContext={"groups"={"comments:collection"}},
 *      denormalizationContext={"groups"={"comments:write"}},
 *      paginationItemsPerPage= 20,
 *      paginationMaximumItemsPerPage= 20,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *                "lastcomments"={
 *                  "method"="GET",
 *                  "path"="/home/lastcomments",
 *                  "controller"=App\Controller\LastNewComments::class,
 *                  "normalization_context"={"groups"={"lastcomments:collection"}},
 *               },
 *               "dashboard/admin/comments"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/comments",
 *                  "security"= "is_granted('ROLE_ADMIN')",
 *                  "normalization_context"={"groups"={"admin:comments", "enable_max_depth"=true}},  
 *               },
 *               "properties_{id}_comments"={
 *                  "method"="POST",
 *                  "path"="properties/{id}/comments",
 *                  "denormalization_context"={"groups"={"comments:reservations", "reservations:comments", "user:comments", "enable_max_depth"=true}}, 
 *                  "security"= "is_granted('ROLE_USER')",
 * },   
 *             
 *          },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"comments:collection", "comments:item"}}},
 *          "patch"={},
 *          "put"={"security"= "is_granted('ROLE_USER')"},
 *          "delete"={},
 *               "dashboard/user/comments/{id}"={
 *                  "method"="GET",
 *                  "path"="dashboard/user/comments/{id}",
 *                  "security"="is_granted('ROLE_USER')",
 *                  "normalization_context"={"groups"={"read:commentsid", "enable_max_depth"=true}},  
 *               },  
 *               "dashboard/admin/comments/{id}"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/comments/{id}",
 *                  "security"="is_granted('ROLE_ADMIN')",
 *                  "normalization_context"={"groups"={"admin:commentsid", "enable_max_depth"=true}},  
 *               }, 
 *              "dashboard/user/comments/details/{id}/modify"={
 *                  "method"="PATCH",
 *                  "path"="dashboard/user/comments/details/{id}/modify",
 *                  "security"="is_granted('ROLE_USER')",
 *                  "deserialize"=false,
 *              },             
 *          }
 * )
 * @ApiFilter(SearchFilter::class, properties= {"user.id": "exact"})
 * @ApiFilter(DateFilter::class, properties= {"created_at"})
 * @ApiFilter(OrderFilter::class, properties= {"created_at": "ASC", "created_at": "DESC", "reservations.properties.title": "ASC",  "reservations.properties.title": "DESC", "value" : "ASC", "value" : "DESC"})
 */
class Comments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"comments:collection", "read:reportsid", "read:reports", "admin:reports", "admin:reportsid", "properties:map", "admin:usertest", "propertiesid:item", "admin:usersid", "admin:commentsid", "properties:collection", "admin:comments", "lastcomments:collection", "reservations:user", "owner:propertiesid", "properties:collection", "read:commentsperso", "read:commentsid", "reservations:user", "reservations:item", "properties:item", "categories:item", "properties:comments", "comments:reports"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"comments:collection", "read:reportsid", "read:reports", "admin:reports", "admin:reportsid", "admin:usertest", "propertiesid:item", "admin:usersid", "admin:commentsid", "admin:comments", "lastcomments:collection", "reservations:user", "owner:propertiesid", "read:commentsperso", "read:commentsid", "reservations:item", "reservations:user", "properties:item", "properties:comments", "comments:reservations"})
     */
    private $body;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"comments:item", "properties:map", "admin:usertest", "propertiesid:item", "admin:usersid", "properties:collection", "admin:commentsid", "reservations:item", "admin:comments", "categories:item", "reservations:user", "owner:propertiesid", "properties:collection", "read:commentsperso", "read:commentsid", "properties:comments", "reservations:user", "lastcomments:collection", "comments:reservations"})
     */
    private $value;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"comments:item", "read:reportsid", "read:reports", "admin:reportsid", "admin:usertest", "admin:commentsid", "reservations:item", "admin:comments", "properties:comments", "read:commentsperso", "owner:propertiesid", "read:commentsid"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"comments:item","admin:commentsid", "admin:usertest", "reservations:item"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @Groups({"comments:item", "read:reports", "read:reportsid", "admin:reportsid", "admin:reports", "admin:usersid", "propertiesid:item", "reservations:user", "admin:commentsid","reservations:item", "lastcomments:collection", "read:commentsid", "properties:item", "comments:reservations"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Reservations::class, inversedBy="comments")
     * @Groups({"comments:item", "read:commentsid", "read:commentsperso", "admin:comments", "admin:commentsid", "lastcomments:collection", "comments:reservations"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity=Reports::class, mappedBy="comments")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $reports;


    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->reports = new ArrayCollection();
        
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUserpicture(): ?string
    {
        return $this->userpicture;
    }

    public function setUserpicture(string $userpicture): self
    {
        $this->userpicture = $userpicture;

        return $this;
    }

    public function getPropertypicture(): ?string
    {
        return $this->propertypicture;
    }

    public function setPropertypicture(string $propertypicture): self
    {
        $this->propertypicture = $propertypicture;

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

   
    public function getReservations(): ?Reservations
    {
        return $this->reservations;
    }

    public function addReservation(Reservations $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->addComment($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            $reservation->removeComment($this);
        }

        return $this;
    }

    public function setReservations(?Reservations $reservations): self
    {
        $this->reservations = $reservations;
        
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
     * @return Collection|Reports[]
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Reports $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports[] = $report;
            $report->setComments($this);
        }

        return $this;
    }

    public function removeReport(Reports $report): self
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getComments() === $this) {
                $report->setComments(null);
            }
        }

        return $this;
    }

   

   

   
}
