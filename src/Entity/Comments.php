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
 * @ApiResource( normalizationContext={"groups"={"comments:read"}},
 *      denormalizationContext={"groups"={"comments:write"}},
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *                "lastnewcomments"={
 *                  "method"="GET",
 *                  "path"="comments/lastnewcomments",
 *                  "controller"=App\Controller\LastNewComments::class
 *          },
 *          },
 *      itemOperations={
 * 
 *          "get"={},
 *          "put"={},
 *          "delete"={},
 *          }
 * )
 */
class Comments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"comments:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"comments:read","comments:write"})
     */
    private $body;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"comments:read","comments:write"})
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"comments:read","comments:write"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"comments:read","comments:write"})
     */
    private $userpicture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"comments:read","comments:write"})
     */
    private $propertypicture;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"comments:read"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"comments:read"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity=Reservations::class, mappedBy="comments")
     */
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
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

    /**
     * @return Collection|Reservations[]
     */
    public function getReservations(): Collection
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
}
