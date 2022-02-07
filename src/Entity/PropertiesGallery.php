<?php

namespace App\Entity;

use App\Repository\PropertiesGalleryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints\Uuid;

/**
 * @ORM\Entity(repositoryClass=PropertiesGalleryRepository::class)
 * @Vich\Uploadable()
 *  @ApiResource(
 *      normalizationContext={"groups"={"propertiesgallery:collection"}},
 *      denormalizationContext={"groups"={"propertiesgallery:write"}},
 *      paginationItemsPerPage= 20,
 *      paginationMaximumItemsPerPage= 20,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *             "dashboard/owner/properties/details/galleryphoto/{id}/addpictures"={
 *                  "method"="POST",
 *                  "path"="dashboard/owner/properties/details/galleryphoto/{id}/addpictures",
 *                  "deserialize"=false,
 *                  "controller"="App\Requests\CreatePropertiesGallery::newPropertiesGallery" ,   
 *                }, 
 * 
 *                "dashboard/propertiesgallery/create"={
 *                  "method"="POST",
 *                  "path"="dashboard/propertiesgallery/create",
 *                  "deserialize" = false,
 *                  "controller"="App\Requests\CreatePropertiesGallery::newPropertiesGallery",
 *                  "openapi_context" = {
 *                  "requestBody" = {
 *                     "content" = {
 *                         "multipart/form-data" = {
 *                             "schema" = {
 *                                 "type" = "object",
 *                                 "properties" = {

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
 * 
 * 
 *              
 *          },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"propertiesgallery:collection", "propertiesgallery:item"}}},
 *        
 *          "put"={"security"= "is_granted('ROLE_OWNER', 'ROLE_ADMIN')"},
 *          "delete"={},
 *          }
 * )
 */
class PropertiesGallery
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"propertiesgallery:collection", "owner:propertiesid", "properties:item", "propertiesid:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"propertiesgallery:collection", "propertiesgallery:write", "owner:propertiesid", "properties:item", "propertiesid:item", "galleryphoto:create"})
     */
    private $picture;


    /**
     * @var File|null
     * @Vich\UploadableField(mapping="gallery_images", fileNameProperty="picture")
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
     * @ORM\Column(type="datetime")
     *
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Properties::class, inversedBy="propertiesGalleries")
     * @Groups({"galleryphoto:create", "propertiesgallery:write"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $properties;

    public function __construct()
    {

        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
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
     * @return PropertiesGallery
     */
    public function setFile(?File $file): PropertiesGallery
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
     * @return PropertiesGallery
     */
    public function setFileUrl(?string $fileUrl): PropertiesGallery
    {
        $this->fileUrl = $fileUrl;
        return $this;
    }
}
