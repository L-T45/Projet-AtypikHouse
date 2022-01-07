<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoriesRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"categories:collection"}},
 *      denormalizationContext={"groups"={"categories:write"}},
 *      paginationItemsPerPage= 2,
 *      paginationMaximumItemsPerPage= 2,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},        
 *          },
 * 
 *      itemOperations={
 *            "get"={"normalization_context"={"groups"={"categories:collection", "categories:item"}}},
 *           
 *          "put"={},
 *          "delete"={},
 *          })
 */
class Categories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"categories:collection","attributes:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"categories:collection","categories:write", "properties:item", "attributes:item"})
     */
    private $title;

     /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"categories:write", "properties:item"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"categories:collection", "categories:write"})
     * 
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"categories:item", "categories:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"categories:write"})
     * 
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"categories:write"})
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Properties::class, mappedBy="categories")
     * @Groups({"categories:item", "categories:write"})
     */ 
    private $properties;

    /**
     * @ORM\OneToMany(targetEntity=Attributes::class, mappedBy="categories")
     * @Groups({"categories:item"})
     */
    private $attributes;

  

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->attributes = new ArrayCollection();
       
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
            $property->setCategories($this);
        }

        return $this;
    }

    public function removeProperty(Properties $property): self
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getCategories() === $this) {
                $property->setCategories(null);
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

    /**
     * @return Collection|Attributes[]
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    public function addAttribute(Attributes $attribute): self
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes[] = $attribute;
            $attribute->setCategories($this);
        }

        return $this;
    }

    public function removeAttribute(Attributes $attribute): self
    {
        if ($this->attributes->removeElement($attribute)) {
            // set the owning side to null (unless already changed)
            if ($attribute->getCategories() === $this) {
                $attribute->setCategories(null);
            }
        }

        return $this;
    }


}
