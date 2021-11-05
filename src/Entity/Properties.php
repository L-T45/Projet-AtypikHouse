<?php

namespace App\Entity;

use App\Repository\PropertiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PropertiesRepository::class)
 * @ApiResource(
 *  normalizationContext={"groups"={"read:collection"}},
 *  itemOperations={"get"={"normalization_context"={"groups"={"read:collection", "read:item"}}}, "put"}
 * )
 */
class Properties
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $slug;

    /**
     * @ORM\Column(type="float")
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $rooms;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $booking;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $city;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=5)
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $lat;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=5)
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $longitude;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=3)
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $surface;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $country;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $capacity;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $zipCode;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity=Equipements::class, inversedBy="properties")
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $equipements;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="properties")
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Reservations::class, mappedBy="properties")
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $reservations;

    /**
     * @ORM\ManyToOne(targetEntity=PropertiesGallery::class, inversedBy="properties")
     * @Groups({"read:collection"})
     * @Groups({"read:item"})
     */
    private $propertiesgallery;

    public function __construct()
    {
        $this->equipements = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();

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
}
