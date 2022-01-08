<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

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
 *                 
 *               },
 *             
 *          },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"comments:collection", "comments:item"}}},
 *          "put"={},
 *          "delete"={},
 * 
 *                   "Dashboard/user/comments/{id}"={
 *                  "method"="GET",
 *                  "path"="Dashboard/user/comments/{id}",
 *                  "normalization_context"={"groups"={"read:commentsid", "enable_max_depth"=true}},  
 *               },  
 *                
 *          }
 * )
 */
class Comments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"comments:collection", "lastcomments:collection", "reservations:user", "owner:propertiesid", "properties:collection", "read:commentsperso", "read:commentsid", "reservations:user", "reservations:item", "properties:item", "categories:item", "properties:comments"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"comments:collection", "lastcomments:collection", "reservations:user", "owner:propertiesid", "read:commentsperso", "read:commentsid", "reservations:item", "reservations:user", "properties:item", "properties:comments"})
     */
    private $body;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"comments:item", "reservations:item", "categories:item", "reservations:user", "owner:propertiesid", "properties:collection", "read:commentsperso", "read:commentsid", "properties:comments", "reservations:user", "lastcomments:collection"})
     */
    private $value;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"comments:item", "reservations:item", "properties:comments", "read:commentsperso", "owner:propertiesid", "read:commentsid"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"comments:item", "reservations:item"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @Groups({"comments:item","reservations:item", "lastcomments:collection", "read:commentsid"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Reservations::class, inversedBy="comments")
     * @Groups({"comments:item", "read:commentsid", "read:commentsperso"})
     */
    private $reservations;

  

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        
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

   
}
