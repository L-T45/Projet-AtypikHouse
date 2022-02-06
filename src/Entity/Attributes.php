<?php

namespace App\Entity;

use App\Repository\AttributesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
 *            "dashboard/admin/categories/attributes"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/categories/attributes",
 *                  "force_eager"=false,
 *                  "security"= "is_granted('ROLE_ADMIN')",
 *                  "normalization_context"={"groups"={"admin:categattributes", "enable_max_depth"=true}},
 *               }, 
 *             "dashboard/admin/categories/attributes/create"={
 *                  "method"="POST",
 *                  "path"="dashboard/admin/categories/attributes/create",
 *                  "denormalization_context"={"groups"={"admin:attributescreate", "attributes:categories", "enable_max_depth"=true}},
 *               },              
 *          },
 *      itemOperations={ 
 *          "get"={"normalization_context"={"groups"={"attributes:collection", "attributes:item"}}},        
 *          "put"={},
 *          "delete"={}, 
 *                  "dashboard/admin/categories/attributes/{id}"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/categories/attributes/{id}",
 *                  "force_eager"=false,
 *                  "security"= "is_granted('ROLE_ADMIN')",
 *                  "normalization_context"={"groups"={"admin:categattributesid", "attributes:item", "enable_max_depth"=true}},
 *               },  
 *                  "dashboard/admin/attibute/{id}"={
 *                  "method"="PATCH",
 *                  "path"="dashboard/admin/attibute/{id}",
 *                  "security"= "is_granted('ROLE_ADMIN')",
 *                  "deserialize" = false, 
 *              },        
 *          }
 * )
 */
class Attributes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"attributes:collection", "propertiesid:item", "admin:attributescategoriesid", "categories:item", "admin:categoriesid", "admin:categattributes", "admin:categattributesid"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"attributes:collection", "propertiesid:item", "admin:attributescategoriesid", "categories:item", "admin:categoriesid", "admin:categattributes", "admin:categattributesid", "admin:attributescreate", "update:attribute"})
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
     * @Groups({"attributes:item", "admin:categattributes", "admin:categattributesid", "admin:attributescreate", "update:attribute"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=AttributesAnswers::class, mappedBy="attributes")
     */
    private $attributesAnswers;

    /**
     * @Groups({"admin:attributescategoriesid", "propertiesid:item"})
     * @ORM\Column(type="string", length=20)
     */
    private $response_type;

    /**
     * @Groups({"admin:attributescategoriesid", "propertiesid:item"})
     * @ORM\Column(type="boolean")
     */
    private $required;

    public function __construct()
    {

        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->attributesAnswers = new ArrayCollection();
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

    /**
     * @return Collection|AttributesAnswers[]
     */
    public function getAttributesAnswers(): Collection
    {
        return $this->attributesAnswers;
    }

    public function addAttributesAnswer(AttributesAnswers $attributesAnswer): self
    {
        if (!$this->attributesAnswers->contains($attributesAnswer)) {
            $this->attributesAnswers[] = $attributesAnswer;
            $attributesAnswer->setAttributes($this);
        }

        return $this;
    }

    public function removeAttributesAnswer(AttributesAnswers $attributesAnswer): self
    {
        if ($this->attributesAnswers->removeElement($attributesAnswer)) {
            // set the owning side to null (unless already changed)
            if ($attributesAnswer->getAttributes() === $this) {
                $attributesAnswer->setAttributes(null);
            }
        }

        return $this;
    }

    public function getResponseType(): ?string
    {
        return $this->response_type;
    }

    public function setResponseType(string $response_type): self
    {
        $this->response_type = $response_type;

        return $this;
    }

    public function getRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }
}
