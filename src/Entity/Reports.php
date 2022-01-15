<?php

namespace App\Entity;

use App\Repository\ReportsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReportsRepository::class)
 * @ApiResource( normalizationContext={"groups"={"reports:collection"}},
 *      denormalizationContext={"groups"={"reports:write"}},
 *      paginationItemsPerPage= 20,
 *      paginationMaximumItemsPerPage= 20,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 * 
 *                  "dashboard/admin/reports"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/reports",
 *                  "normalization_context"={"groups"={"admin:reports", "enable_max_depth"=true}},  
 *               },  
 *               
 *          },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"reports:collection", "reports:item"}}},
 *          "put"={},
 *          "delete"={},
 * 
 *                  "dashboard/user/reports/{id}"={
 *                  "method"="GET",
 *                  "path"="dashboard/user/reports/{id}",
 *                  "normalization_context"={"groups"={"read:reportsid", "enable_max_depth"=true}}, 
 *                  
 *               },  
 *                  "dashboard/admin/reports/{id}"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/reports/{id}",
 *                  "normalization_context"={"groups"={"admin:reportsid", "enable_max_depth"=true}},  
 *               },  
 *          }
 * )
 */
class Reports
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"reports:collection", "read:reports", "propertiesid:item", "read:reportsid", "admin:reports", "admin:reportsid"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"reports:collection", "reports:write", "propertiesid:item", "read:reports", "read:reportsid", "admin:reports", "admin:reportsid"})
     */
    private $reportstate;

      /**
     * @ORM\Column(type="text")
     * @Groups({"reports:collection", "propertiesid:item", "reports:write", "read:reports", "read:reportsid", "admin:reports", "admin:reportsid"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"reports:item", "read:reportsid", "admin:reportsid", "propertiesid:item"})
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=ReportsCategories::class, inversedBy="reports")
     * @Groups({"reports:item", "read:reports", "read:reportsid", "admin:reports", "admin:reportsid", "propertiesid:item"})
     */
    private $reportscategories;

   

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="reports")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Properties::class, mappedBy="reports")
     */
    private $properties;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="reports")
     */
    private $users;

  

    
    public function __construct()
    {
        
        $this->created_at = new \DateTime();
        $this->comments = new ArrayCollection();
        $this->properties = new ArrayCollection();
        $this->users = new ArrayCollection();

    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReportState(): ?string
    {
        return $this->reportstate;
    }

    public function setReportState(string $reportstate): self
    {
        $this->reportstate = $reportstate;

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

    public function getReportscategories(): ?Reportscategories
    {
        return $this->reportscategories;
    }

    public function setReportscategories(?Reportscategories $reportscategories): self
    {
        $this->reportscategories = $reportscategories;

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

    

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setReports($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getReports() === $this) {
                $comment->setReports(null);
            }
        }

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
            $property->setReports($this);
        }

        return $this;
    }

    public function removeProperty(Properties $property): self
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getReports() === $this) {
                $property->setReports(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setReports($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getReports() === $this) {
                $user->setReports(null);
            }
        }

        return $this;
    }
}
