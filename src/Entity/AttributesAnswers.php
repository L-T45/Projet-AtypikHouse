<?php

namespace App\Entity;

use App\Repository\AttributesAnswersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttributesAnswersRepository::class)
 */
class AttributesAnswers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $response_string;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $response_bool;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $response_nbr;

    /**
     * @ORM\ManyToOne(targetEntity=Properties::class, inversedBy="attributesAnswers")
     */
    private $properties;

    /**
     * @ORM\ManyToOne(targetEntity=Attributes::class, inversedBy="attributesAnswers")
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
