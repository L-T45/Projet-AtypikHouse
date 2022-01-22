<?php

namespace App\Entity;

use App\Repository\AttributesRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

// Ajout de la route dashboard/admin/categories/attributes/create
/**
 * @ORM\Entity(repositoryClass=AttributesRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"attributes:collection"}},
 *      denormalizationContext={"groups"={"attributes:write"}},
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *                
 *            "dashboard/admin/categories/attributes"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/categories/attributes",
 *                  "force_eager"=false,
 *                  "normalization_context"={"groups"={"admin:categattributes", "enable_max_depth"=true}},
 *               },
 * 
 *             "dashboard/admin/categories/attributes/create"={
 *                  "method"="POST",
 *                  "path"="dashboard/admin/categories/attributes/create",
 *                  "denormalization_context"={"groups"={"admin:attributescreate", "attributes:categories", "enable_max_depth"=true}},
 *               },    
 *              
 *          },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"attributes:collection", "attributes:item"}}},
 *        
 *          "put"={},
 *          "delete"={},
 * 
 *              "dashboard/admin/categories/attributes/{id}"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/categories/attributes/{id}",
 *                  "force_eager"=false,
 *                  "normalization_context"={"groups"={"admin:categattributesid", "attributes:item", "enable_max_depth"=true}},
 *               },
 *               
 *          }
 * )
 */
class Attributes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"attributes:collection", "propertiesid:item", "categories:item", "admin:categoriesid", "admin:categattributes", "admin:categattributesid"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"attributes:collection", "propertiesid:item", "categories:item", "admin:categoriesid", "admin:categattributes", "admin:categattributesid", "admin:attributescreate"})
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"attributes:item", "admin:categattributes", "admin:categattributesid"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"attributes:item", "admin:categattributes", "admin:categattributesid"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="attributes")
     * @Groups({"attributes:item", "admin:categattributes", "admin:categattributesid", "admin:attributescreate"})
     */
    private $categories;


    public function __construct()
    {
       
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

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }
}
