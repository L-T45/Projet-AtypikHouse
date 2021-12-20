<?php

namespace App\Entity;

use App\Repository\EquipementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EquipementsRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"equipements:collection"}},
 *      denormalizationContext={"groups"={"equipements:write"}},
 *      paginationItemsPerPage= 2,
 *      paginationMaximumItemsPerPage= 2,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *                "lastnewequipements"={
 *                  "method"="GET",
 *                  "path"="equipements/lastnewequipements",
 *                  "controller"=App\Controller\LastNewequipements::class
 *          },
 *              
 *          },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"equipements:collection", "equipements:item","read:equipements"}}},
 *          "categoriesbyproperty"={
 *                  "method"="GET",
 *                  "path"="equipements/categoriesbyproperty/{id}",
 *                  "controller"=App\Controller\CategoriesByProperty::class
 *          },
 *          "put"={},
 *          "delete"={},
 *          }
 * )
 */
class Equipements
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"equipements:collection"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"equipements:collection", "equipements:write"})
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"equipements:item", "equipements:write"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"equipements:item", "equipements:write"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity=Properties::class, mappedBy="equipements")
     * @Groups({"equipements:item", "equipements:write"})
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
            $property->addEquipement($this);
        }

        return $this;
    }

    public function removeProperty(Properties $property): self
    {
        if ($this->properties->removeElement($property)) {
            $property->removeEquipement($this);
        }

        return $this;
    }
}
