<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
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
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

// Ajout de la route dashboard/admin/categories/create
/**
 * @ORM\Entity(repositoryClass=CategoriesRepository::class)
 * @Vich\Uploadable()
 * @ApiResource(
 *      normalizationContext={"groups"={"categories:collection"}},
 *      denormalizationContext={"groups"={"categories:write"}},
 *      collectionOperations={
 *            "get"={},
 *            "post"={}, 
 *            "dashboard/admin/categories"={
 *                 "method"="GET",
 *                 "path"="dashboard/admin/categories",
 *                 "security"= "is_granted('ROLE_ADMIN')",
 *                 "normalization_context"={"groups"={"admin:categories", "enable_max_depth"=true}},
 *              },   
 *                "dashboard/admin/categories/create"={
 *                  "method"="POST",
 *                  "path"="dashboard/admin/categories/create",
 *                  "deserialize" = false,
 *                  "controller"="App\Requests\CreateCategories::newCategories",
 *                  "openapi_context" = {
 *                  "requestBody" = {
 *                     "content" = {
 *                         "multipart/form-data" = {
 *                             "schema" = {
 *                                 "type" = "object",
 *                                 "properties" = {
 *                                      "title"={
 *                                          "type" = "string"
 *                                          },
 *                                      "slug"={
 *                                          "type" = "string"
 *                                          },                            
 *                                      "description"={
 *                                          "type" = "string"
 *                                          },
 *                                     "file" = {
 *                                         "type" = "array",
 *                                         "items" = {
 *                                             "type" = "string",
 *                                             "format" = "binary"
 *                                         },
 *                                     },
 *                                 },
 *                             },
 *                         },
 *                     },
 *                 },
 *             },
                
 *         
 *                  
 *               }, 
 *      
 *                       
 *          },
 * 
 *      itemOperations={
 *          "get"={"normalization_context"={"groups"={"categories:collection", "categories:item"}}},
 *          "put"={},
 *          "patch"={},
 *          "delete"={},
 *                  "dashboard/admin/categories/{id}"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/categories/{id}",
 *                  "force_eager"=false,
 *                  "normalization_context"={"groups"={"admin:categoriesid", "enable_max_depth"=true}},
 *               },  
 *                  "dashboard/admin/categories/{id}"={
 *                  "method"="PATCH",
 *                  "path"="dashboard/admin/categories/{id}",
 *                  "controller"="App\Controller\CategoriesModifier::UpdateCategories",
 *                  "security"="is_granted('ROLE_ADMIN')",
 *                  "deserialize"=false,
 *                  "openapi_context"= {
 *                      "requestBody" = {
 *                          "content" = {
 *                              "multipart/form-data" = {
 *                                  "schema" = {
 *                                      "type" = "object",
 *                                      "properties" = {
 *                                          "title" = {
 *                                              "type" = "string"
 *                                          },
 *                                          "slug" = {
 *                                              "type" = "string"
 *                                          },
 *                                          "description" = {
 *                                              "type" = "string"
 *                                          },
 *                                          "file" = {
 *                                              "type" = "array",
 *                                              "items" = {
 *                                                  "type" = "string",
 *                                                  "format" = "binary"
 *                                              },
 *                                          },
 *                                      },
 *                                  },
 *                              },
 *                          },
 *                      },
 *                  },
 *               },
 *                 
 *                  "dashboard/admin/attributes/categories/{id}"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/attributes/categories/{id}",
 *                  "force_eager"=false,
 *                  "normalization_context"={"groups"={"admin:attributescategoriesid", "enable_max_depth"=true}},
 *                  
 *               }, 
 *                  
 * 
 *                  "dashboard/admin/update/categories/{id}"={
 *                  "method"="POST",
 *                  "path"="dashboard/admin/update/categories/{id}",
 *                  "deserialize" = false,
 *                  "controller"=App\Controller\UpdateCategoriesController::class,
 *                  "openapi_context" = {
 *                  "requestBody" = {
 *                     "content" = {
 *                         "multipart/form-data" = {
 *                             "schema" = {
 *                                 "type" = "object",
 *                                 "properties" = {
 *                                      "title"={
 *                                          "type" = "string"
 *                                          },                         
 *                                      "description"={
 *                                          "type" = "string"
 *                                          },
 *                                     "file" = {
 *                                         "type" = "array",
 *                                         "items" = {
 *                                             "type" = "string",
 *                                             "format" = "binary"
 *                                         },
 *                                     },
 *                                 },
 *                             },
 *                         },
 *                     },
 *                 },
 *             },
                
 *         
 *                  
 *               }, 
 *      
 *                 
 *          }
 * )
 * 
 */
class Categories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"categories:collection", "read:reportsid", "read:reports", "admin:reports", "admin:reportsid", "properties:map", "admin:properties", "propertiesid:item", "admin:usersid", "propertiesid:item", "admin:commentsid", "attributes:item", "admin:categattributesid", "admin:categattributes", "admin:categoriesid", "reservations:user", "owner:propertiesid", "owner:reservid", "admin:categories", "attributes:categories"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"categories:collection", "read:reportsid", "read:reports", "admin:reports", "admin:reportsid", "properties:map", "admin:properties", "admin:usersid", "propertiesid:item", "propertiesid:item", "admin:commentsid",  "categories:item", "admin:categattributesid", "admin:categattributes", "admin:categories", "admin:categoriesid", "categories:write", "owner:propertiesid", "owner:reservid", "properties:item", "attributes:item", "reservations:user", "admin:createcategories"})
     */
    private $title;

     /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"categories:collection", "categories:item", "admin:categories", "admin:categoriesid", "categories:write", "properties:item", "admin:createcategories"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"categories:item", "categories:write", "admin:categories", "admin:categoriesid", "admin:createcategories", "categories:collection"})
     * 
     */
    private $picture;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="categories_images", fileNameProperty="picture")
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $filePath;

    /**
     * @var string|null
     * @Groups({"properties:collection", "properties:write"})
     */
    private $fileUrl;


     /**
     * @ORM\Column(type="text")
     * @Groups({"categories:item","categories:write", "admin:categoriesid", "admin:createcategories"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"categories:write", "admin:categoriesid"})
     * 
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"categories:write", "admin:categoriesid"})
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Properties::class, mappedBy="categories")
     * @Groups({"categories:item", "categories:write", "admin:categoriesid"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */ 
    private $properties;

    /**
     * @ORM\OneToMany(targetEntity=Attributes::class, mappedBy="categories")
     * @Groups({"categories:item", "admin:categoriesid", "propertiesid:item", "admin:attributescategoriesid"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
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

    
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }


    /**
     * @return File|null $file
     * @return Categories
     */
    public function setFile(?File $file): Categories
    {
        $this->file = $file;
        return $this;
    }
  
    /**
     * @return string|null
     */
    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }

    /**
     * @return string|null $fileUrl
     * @return Categories
     */
    public function setFileUrl(?string $fileUrl): Categories
    {
        $this->fileUrl = $fileUrl;
        return $this; 
    }


}
