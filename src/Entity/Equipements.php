<?php

namespace App\Entity;

use App\Repository\EquipementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

// Ajout route personalisé ici (lastnewequipements, equipements_id) car pas possible à un autre endroit visiblement.

/**
 * @ORM\Entity(repositoryClass=EquipementsRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"equipements:collection"}},
 *      denormalizationContext={"groups"={"equipements:write"}},
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *                "lastnewequipements"={
 *                   "method"="GET",
 *                   "path"="dashboard/admin/equipements",
 *                   "force_eager"=false,
 *                   "security"= "is_granted('ROLE_ADMIN')",
 *                   "normalization_context"={"groups"={"equipements:collection", "enable_max_depth"=true}}
 *                 },               
 *                  "dashboard/admin/properties/equipements"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/properties/equipements",
 *                  "security"= "is_granted('ROLE_ADMIN')",
 *                  "normalization_context"={"groups"={"admin:proequip", "enable_max_depth"=true}},                  
 *               },   
 *          },
 *      itemOperations={          
 *          "get"={"normalization_context"={"groups"={"equipements:collection", "equipements:item","read:equipements"}}},
 *          "put"={},
 *          "delete"={},
 *              "dashboard/admin/properties/equipments/{id}"={
 *                   "method"="GET",
 *                   "path"="dashboard/admin/properties/equipments/{id}",
 *                   "force_eager"=false,
 *                   "security"= "is_granted('ROLE_ADMIN')",
 *                   "normalization_context"={"groups"={"equipements:collection", "equipements:item", "enable_max_depth"=true}}
 *                 }, 
 *          }
 * )
 */
class Equipements
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"equipements:collection", "owner:propertiesid", "admin:proequip", "propertiesid:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"equipements:collection", "equipements:write", "owner:propertiesid", "admin:proequip", "propertiesid:item"})
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"equipements:item", "equipements:write", "admin:proequip"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"equipements:item", "equipements:write", "admin:proequip"})
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity=Properties::class, mappedBy="equipements")
     * @Groups({"equipements:item", "equipements:write", "admin:proequip"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
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
