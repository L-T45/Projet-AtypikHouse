<?php

namespace App\Entity;

use App\Repository\PropertiesRepository;
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

// Ajout route personalisé ici (lastnewproperties, dashboard_admin_properties, dashboard_admin_properties_id, dashboard_user_properties_id) car pas possible à un autre endroit visiblement.
/**
 * @ORM\Entity(repositoryClass=PropertiesRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"properties:collection"}},
 *      denormalizationContext={"groups"={"properties:write"}},
 *      paginationItemsPerPage= 20,
 *      paginationMaximumItemsPerPage= 20,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *                 "lastnewproperties"={
 *                      "method"="GET",
 *                      "path"="home/lastproperties",
 *                      "controller"=App\Controller\LastNewProperties::class,
 *                      "force_eager"=false,
 *                      "normalization_context"={"groups"={"properties:collection", "enable_max_depth"=true}}
 *                 }, 
 *                 "dashboard_admin_properties"={
 *                      "method"="GET",
 *                      "path"= "dashboard/admin/properties",
 *                      "controller"=App\Controller\LastNewProperties::class,
 *                      "force_eager"=false,
 *                      "normalization_context"={"groups"={"properties:collection", "enable_max_depth"=true}}
 *                 },              
 *          },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"propertiesid:item"}}},       
 *          "put"={},
 *          "delete"={},
 *               "dashboard_admin_properties_id"={
 *                      "method"="GET",
 *                      "path"= "dashboard/admin/properties/{id}",
 *                      "force_eager"=false,
 *                      "normalization_context"={"groups"={"properties:collection", "properties:item", "enable_max_depth"=true}}
 *                 },
 *                "dashboard_user_properties_id"={
 *                      "method"="GET",
 *                      "path"= "dashboard/user/properties/{id}",
 *                      "force_eager"=false,
 *                      "normalization_context"={"groups"={"properties:user", "enable_max_depth"=true}}
 *                 },
 *                   "comments_properties_id"={
 *                      "method"="GET",
 *                      "path"= "comments/properties/{id}",
 *                      "force_eager"=false,
 *                      "normalization_context"={"groups"={"properties:comments", "enable_max_depth"=true}}
 *                 },
 *          }
 * )
 * @ApiFilter(SearchFilter::class, properties= {"categories.id": "exact", "equipements.title": "partial", "price": "exact", "capacity": "exact", "lat": "exact", "longitude": "exact", "reservations.comments.value": "exact"})
 * @ApiFilter(RangeFilter::class, properties= {"surface", "rooms", "bedrooms"})
 * @ApiFilter(DateFilter::class, properties= {"reservations.startdate"})
 * @ApiFilter(OrderFilter::class, properties= {"id": "DESC", "price": "ASC", "price": "DESC", "reservations.comments.value": "ASC", "reservations.comments.value": "DESC"})
 * 
 */
class Properties
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"properties:collection", "lastcomments:collection", "propertiesid:item", "reservations:user", "categories:item", "comments:item", "user:properties", "propertiesgallery:item", "properties:user"})
     * 
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"properties:collection", "propertiesid:item", "properties:write", "categories:item", "reservations:user", "user:properties", "propertiesgallery:item", "properties:user" })
     *
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"properties:write", "propertiesid:item", "properties:item", "user:properties"})
     */
    private $slug;

    /**
     * @ORM\Column(type="float")
     * @Groups({"properties:write", "propertiesid:item", "properties:item", "categories:item", "reservations:user"})
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"properties:write", "propertiesid:item", "properties:item", "categories:item"})
     */
    private $rooms;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"properties:collection","properties:write", "user:properties", "categories:item", "reservations:user"})
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"properties:item", "propertiesid:item", "properties:write"})
     */
    private $booking;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"properties:collection", "properties:write", "user:properties", "categories:item", "reservations:user"})
     * 
     */
    private $city;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=5)
     * @Groups({"properties:write", "propertiesid:item", "properties:item"})
     * 
     */
    private $lat;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=5)
     * @Groups({"properties:write", "propertiesid:item", "properties:item"})
     */
    private $longitude;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"properties:write", "propertiesid:item", "properties:item", "categories:item"})
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=3)
     * @Groups({"properties:write", "properties:item","categories:item"})
     */
    private $surface;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"properties:write", "properties:item"})
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"properties:collection", "properties:write", "reservations:user", "categories:item", "comments:item", "user:properties", "propertiesgallery:item", "lastcomments:collection", "read:reservations"})
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"properties:write", "properties:item"})
     */
    private $country;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"properties:item", "properties:write", "categories:item"})
     */
    private $capacity;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"properties:write", "properties:item"})
     */
    private $zipCode;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"properties:write", "properties:item"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"properties:write", "properties:item"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity=Equipements::class, inversedBy="properties")
     * @Groups({"properties:write", "properties:item"})
     */
    private $equipements;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="properties")
     * @Groups({"properties:item", "properties:write", "reservations:user"})
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Reservations::class, mappedBy="properties")
     * @Groups({"properties:item", "properties:write"})
     */
    private $reservations;

    /**
     * @ORM\ManyToOne(targetEntity=PropertiesGallery::class, inversedBy="properties")
     * @Groups({"properties:item", "properties:write"})
     */
    private $propertiesgallery;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="properties")
     * @Groups({"properties:user"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="properties")
     * @Groups({"properties:item", "reservations:user"})
     */
    private $comments;

    public function __construct()
    {
        $this->equipements = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->comments = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getBooking(): ?int
    {
        return $this->booking;
    }

    public function setBooking(int $booking): self
    {
        $this->booking = $booking;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

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
     * @return Collection|Equipements[]
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipements $equipement): self
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements[] = $equipement;
        }

        return $this;
    }

    public function removeEquipement(Equipements $equipement): self
    {
        $this->equipements->removeElement($equipement);

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getPropertiesgallery(): ?Propertiesgallery
    {
        return $this->propertiesgallery;
    }

    public function setPropertiesgallery(?Propertiesgallery $propertiesgallery): self
    {
        $this->propertiesgallery = $propertiesgallery;

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
            $reservation->setProperties($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getProperties() === $this) {
                $reservation->setProperties(null);
            }
        }

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
            $comment->setProperties($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProperties() === $this) {
                $comment->setProperties(null);
            }
        }

        return $this;
    }
}
