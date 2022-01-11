<?php

namespace App\Entity;

use App\Repository\PropertiesGalleryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PropertiesGalleryRepository::class)
 *  @ApiResource(
 *      normalizationContext={"groups"={"propertiesgallery:collection"}},
 *      denormalizationContext={"groups"={"propertiesgallery:write"}},
 *      paginationItemsPerPage= 20,
 *      paginationMaximumItemsPerPage= 20,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *              
 *              
 *          },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"propertiesgallery:collection", "propertiesgallery:item"}}},
 *        
 *          "put"={},
 *          "delete"={},
 *          }
 * )
 */
class PropertiesGallery
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"propertiesgallery:collection", "owner:propertiesid", "properties:item", "propertiesid:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"propertiesgallery:collection", "owner:propertiesid", "properties:item", "propertiesid:item"})
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"propertiesgallery:collection"})
     */
    private $alt;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Properties::class, mappedBy="propertiesgallery")
     *  @Groups({"propertiesgallery:item"})
     */
    private $properties;



    public function __construct()
    {
        $this->properties = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

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
     * @return Collection|Properties[]
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Properties $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
            $property->setPropertiesgallery($this);
        }

        return $this;
    }

    public function removeProperty(Properties $property): self
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getPropertiesgallery() === $this) {
                $property->setPropertiesgallery(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
