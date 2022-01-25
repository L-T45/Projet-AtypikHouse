<?php

namespace App\Entity;

use App\Repository\ReportsRepository;
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

// Ajout route personalisé ici (dashboard/admin/reports, properties_{id}_signalement, properties_comments_{id}_reports, dashboard/admin/reports/{id}, dashboard/user/reports/{id}) car pas possible à un autre endroit visiblement.
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
 *               "dashboard/admin/reports"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/reports",
 *                  "normalization_context"={"groups"={"admin:reports", "enable_max_depth"=true}},  
 *               }, 
 *              "properties_{id}_reports"={
 *                     "method"="POST",
 *                     "path"= "properties/{id}/reports",
 *                     "force_eager"=false,
 *                     "denormalization_context"={"groups"={"reports:properties", "properties:reports", "reportscategories:reports", "user:reports", "enable_max_depth"=true}}, 
 *                },
 *              "properties_comments_{id}_reports"={
 *                     "method"="POST",
 *                     "path"= "properties/comments/{id}/reports",
 *                     "force_eager"=false,
 *                     "denormalization_context"={"groups"={"reports:comments", "comments:reports", "reportscategories:reports", "user:reports", "enable_max_depth"=true}}, 
 *                },   
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
 * @ApiFilter(DateFilter::class, properties= {"created_at"})
 * @ApiFilter(OrderFilter::class, properties= {"reportscategories.title": "ASC", "reportscategories.title": "DESC", "comments.id": "ASC", "comments.id": "DESC", "user.lastname": "ASC", "user.lastname": "DESC"})
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
     * @Groups({"reports:collection", "reports:write", "propertiesid:item", "read:reports", "read:reportsid", "admin:reports", "admin:reportsid", "reports:properties", "reports:comments"})
     */
    private $reportstate;

      /**
     * @ORM\Column(type="text")
     * @Groups({"reports:collection", "propertiesid:item", "reports:write", "read:reports", "read:reportsid", "admin:reports", "admin:reportsid", "reports:properties", "reports:comments"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"reports:item", "read:reportsid", "admin:reportsid", "propertiesid:item"})
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=ReportsCategories::class, inversedBy="reports")
     * @Groups({"reports:item", "read:reports", "read:reportsid", "admin:reports", "admin:reportsid", "propertiesid:item", "reports:properties", "reports:comments"})
     */
    private $reportscategories;

    /**
     * @ORM\ManyToOne(targetEntity=Properties::class, inversedBy="reports")
     * @Groups({"reports:properties"})
     */
    private $properties;

    /**
     * @ORM\ManyToOne(targetEntity=Comments::class, inversedBy="reports")
     * @Groups({"reports:comments"})
     */
    private $comments;
    
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reports")
     * @Groups({"reports:properties", "reports:comments", "admin:reportsid"})
     */
    private $user;

   

  

    
    public function __construct()
    {
        
        $this->created_at = new \DateTime();

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

    public function getProperties(): ?Properties
    {
        return $this->properties;
    }

    public function setProperties(?Properties $properties): self
    {
        $this->properties = $properties;

        return $this;
    }

    public function getComments(): ?Comments
    {
        return $this->comments;
    }

    public function setComments(?Comments $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    

   


}
