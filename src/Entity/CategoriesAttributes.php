<?php

namespace App\Entity;

use App\Repository\CategoriesAttributesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoriesAttributesRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"categoriesattributes:collection"}},
 *      denormalizationContext={"groups"={"categoriesattributes:write"}},
 *      paginationItemsPerPage= 2,
 *      paginationMaximumItemsPerPage= 2,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *                "lastnewcategoriesattributes"={
 *                  "method"="GET",
 *                  "path"="categoriesattributes/lastnewcategoriesattributes",
 *                  "controller"=App\Controller\LastNewcategoriesattributes::class
 *          },
 *              
 *          },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"categoriesattributes:collection", "categoriesattributes:item","read:categoriesattributes"}}},
 *          "categoriesbyproperty"={
 *                  "method"="GET",
 *                  "path"="categoriesattributes/categoriesbyproperty/{id}",
 *                  "controller"=App\Controller\CategoriesByProperty::class
 *          },
 *          "put"={},
 *          "delete"={},
 *          }
 * )
 */
class CategoriesAttributes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"categoriesattributes:collection"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"categoriesattributes:collection", "categoriesattributes:write"})
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"categoriesattributes:item", "categoriesattributes:write"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"categoriesattributes:item", "categoriesattributes:write"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity=Categories::class, mappedBy="categoriesattributes")
     * @Groups({"categoriesattributes:item", "categoriesattributes:write"})
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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
     * @return Collection|Categories[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addCategoriesattribute($this);
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeCategoriesattribute($this);
        }

        return $this;
    }
}
