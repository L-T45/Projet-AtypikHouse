<?php

namespace App\Entity;

use App\Repository\AttributesAnswersRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AttributesAnswersRepository::class)
 * @ApiResource()
 */
class AttributesAnswers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"propertiesid:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"propertiesid:item"})
     */
    private $response_string;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"propertiesid:item"})
     */
    private $response_bool;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"propertiesid:item"})
     */
    private $response_nbr;

    /**
     * @ORM\ManyToOne(targetEntity=Properties::class, inversedBy="attributesAnswers")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $properties;

    /**
     * @ORM\ManyToOne(targetEntity=Attributes::class, inversedBy="attributesAnswers")
     * @Groups({"propertiesid:item"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $attributes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponseString(): ?string
    {
        return $this->response_string;
    }

    public function setResponseString(?string $response_string): self
    {
        $this->response_string = $response_string;

        return $this;
    }

    public function getResponseBool(): ?bool
    {
        return $this->response_bool;
    }

    public function setResponseBool(?bool $response_bool): self
    {
        $this->response_bool = $response_bool;

        return $this;
    }

    public function getResponseNbr(): ?int
    {
        return $this->response_nbr;
    }

    public function setResponseNbr(?int $response_nbr): self
    {
        $this->response_nbr = $response_nbr;

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

    public function getAttributes(): ?Attributes
    {
        return $this->attributes;
    }

    public function setAttributes(?Attributes $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }
}
