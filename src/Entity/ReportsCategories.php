<?php

namespace App\Entity;

use App\Repository\ReportsCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReportsCategoriesRepository::class)
 * @ApiResource( normalizationContext={"groups"={"reportscategories:collection"}},
 *      denormalizationContext={"groups"={"reportscategories:write"}},
 *      paginationItemsPerPage= 2,
 *      paginationMaximumItemsPerPage= 2,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},  
 *          },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"reportscategories:collection", "reportscategories:item"}}},
 *          "put"={},
 *          "delete"={},
 *          }
 * )
 */
class ReportsCategories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"reportscategories:collection", "user:reports", "reports:item", "read:reports", "read:reportsid", "admin:reports", "admin:reportsid", "reportscategories:reports"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"reportscategories:collection", "user:reports", "reports:item", "read:reports", "read:reportsid", "admin:reports", "admin:reportsid"})
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"reportscategories:item", "read:reportsid"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"reportscategories:item", "read:reportsid"})
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Reports::class, mappedBy="reportscategories")
     */
    private $reports;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"admin:reportsid"})
     */
    private $reportsobject;

   

    public function __construct()
    {
        $this->reports = new ArrayCollection();
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
     * @return Collection|Reports[]
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Reports $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports[] = $report;
            $report->setReportscategories($this);
        }

        return $this;
    }

    public function removeReport(Reports $report): self
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getReportscategories() === $this) {
                $report->setReportscategories(null);
            }
        }

        return $this;
    }

    public function getReportsobject(): ?string
    {
        return $this->reportsobject;
    }

    public function setReportsobject(string $reportsobject): self
    {
        $this->reportsobject = $reportsobject;

        return $this;
    }
}
