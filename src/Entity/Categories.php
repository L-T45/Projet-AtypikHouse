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
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *               
 *          },
 *      itemOperations={
 *            "get"={"normalization_context"={"groups"={"categories:collection", "categories:item"}}},
 *              "listpropertiesbycategory"={
 *                  "method"="GET",
 *                  "normalization_context"={"groups"={"categories:collection", "categories:item"}},
 *                  "path"="categories/listpropertiesbycategory/{id}",
 *                  "controller"=App\Controller\ListPropertiesByCategory::class
 *          },
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
     * @Groups({"categories:collection"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"categories:collection"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"categories:item"})
     * 
     */
    private $picture;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"categories:item"})
     * 
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"categories:item"})
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Properties::class, mappedBy="categories")
     * @Groups({"categories:item"})
     */
    private $properties;

    /**
     * @ORM\ManyToMany(targetEntity=CategoriesAttributes::class, inversedBy="categories")
     */
    private $categoriesattributes;

    public function __construct()
    {
        $this->categoriesattributes = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
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

    /**
     * @return Collection|Categoriesattributes[]
     */
    public function getCategoriesattributes(): Collection
    {
        return $this->categoriesattributes;
    }

    public function addCategoriesattribute(Categoriesattributes $categoriesattribute): self
    {
        if (!$this->categoriesattributes->contains($categoriesattribute)) {
            $this->categoriesattributes[] = $categoriesattribute;
        }

        return $this;
    }

    public function removeCategoriesattribute(Categoriesattributes $categoriesattribute): self
    {
        $this->categoriesattributes->removeElement($categoriesattribute);

        return $this;
    }
}
