<?php

namespace App\Entity;

use App\Repository\ReportsRepository;
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
 *                  "Dashboard/admin/reports"={
 *                  "method"="GET",
 *                  "path"="Dashboard/admin/reports",
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
 *                  "Dashboard/user/reports/{id}"={
 *                  "method"="GET",
 *                  "path"="Dashboard/user/reports/{id}",
 *                  "normalization_context"={"groups"={"read:reportsid", "enable_max_depth"=true}}, 
 *                  
 *               },  
 *                  "Dashboard/admin/reports/{id}"={
 *                  "method"="GET",
 *                  "path"="Dashboard/admin/reports/{id}",
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
     * @Groups({"reports:collection", "read:reports", "read:reportsid", "admin:reports", "admin:reportsid"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"reports:collection", "reports:write", "read:reports", "read:reportsid", "admin:reports", "admin:reportsid"})
     */
    private $reportstate;

      /**
     * @ORM\Column(type="text")
     * @Groups({"reports:collection", "reports:write", "read:reports", "read:reportsid", "admin:reports", "admin:reportsid"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"reports:item", "read:reportsid", "admin:reportsid"})
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=ReportsCategories::class, inversedBy="reports")
     * @Groups({"reports:item", "read:reports", "read:reportsid", "admin:reports", "admin:reportsid"})
     */
    private $reportscategories;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reports")
     * @Groups({"read:reportsid", "admin:reportsid"})
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
