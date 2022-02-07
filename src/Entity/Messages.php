<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MessagesRepository::class)
 *@ApiResource( normalizationContext={"groups"={"messages:collection"}},
 *      denormalizationContext={"groups"={"messages:write"}},
 *      paginationItemsPerPage= 20,
 *      paginationMaximumItemsPerPage= 20,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *            "api_dashboard/user/conversations/details/{id}/create"={
 *                  "method"="POST",
 *                  "path"="/dashboard/user/conversations/details/{id}/create",
 *                  "force_eager"=false,
 *                  "denormalization_context"={"groups"={"messages:create", "usermessage:create", "convmessage:create", "enable_max_depth"=true}}, 
 *              },
 *      },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"messages:collection", "messages:item"}}},
 *          "put"={"security"= "is_granted('ROLE_USER')"},
 *          "delete"={},
 * 
 * 
 *          

 *          }
 * )
 */
class Messages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"messages:collection", "admin:conversid", "user:conversid", "admin:usersid", "read:messages", "user:messages", "conversations:item", "user:conversations"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"messages:collection", "admin:conversid", "user:conversid", "admin:usersid", "read:messages", "user:messages", "conversations:item", "user:conversations", "messages:create"})
     */
    private $body;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"messages:item", "admin:conversid", "admin:usersid", "user:conversid", "read:messages", "user:messages", "conversations:item", "user:conversations"})
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=Conversations::class, inversedBy="messages")
     * @Groups({"messages:item", "read:messages", "user:messages", "admin:usersid", "messages:create"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $conversations;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages")
     * @Groups({"user:messages", "user:conversid", "messages:create", "admin:conversid"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

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

    public function getConversations(): ?Conversations
    {
        return $this->conversations;
    }

    public function setConversations(?Conversations $conversations): self
    {
        $this->conversations = $conversations;

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
