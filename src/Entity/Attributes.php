<?php

namespace App\Entity;

use App\Repository\AttributesRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AttributesRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"attributes:collection"}},
 *      denormalizationContext={"groups"={"attributes:write"}},
 *      paginationItemsPerPage= 2,
 *      paginationMaximumItemsPerPage= 2,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *                
 *                  "dashboard_admin_attributes"={
 *                  "method"="GET",
 *                  "path"="/dashboard/admin/attributes"
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
 *              "dashboard_admin_attributes"={
 *                  "method"="GET",
 *                  "path"="/dashboard/admin/attributes/{id}",
 *                  "normalization_context"={"groups"={"attributes:collection", "attributes:item"}},
 *               },
 *          }
 * )
 */
class Attributes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"attributes:collection", "categories:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"attributes:collection", "categories:item"})
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"attributes:item"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"attributes:item"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="attributes")
     * @Groups({"attributes:item"})
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
