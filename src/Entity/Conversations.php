<?php

namespace App\Entity;

use App\Repository\ConversationsRepository;
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

//Ajout route dashboard/user/conversations/details/{id}/create
/**
 * @ORM\Entity(repositoryClass=ConversationsRepository::class)
 * @ApiResource( normalizationContext={"groups"={"conversations:collection"}},
 *      denormalizationContext={"groups"={"conversations:write"}},
 *      paginationMaximumItemsPerPage= 20,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *                  "dashboard/admin/conversations"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/conversations",
 *                  "security"= "is_granted('ROLE_ADMIN')",
 *                  "controller"=App\Controller\LastNewConversations::class,                
 *               },    
 *         
 *                          
 *          },
 *      itemOperations={
 *          "get"={"normalization_context"={"groups"={"conversations:collection", "conversations:item"}}},
 *          "put"={"security"= "is_granted('ROLE_USER')"},
 *          "delete"={},            
              
 *           "dashboard/user/conversations/{id}"={
 *           "method"="GET",
 *           "path"="dashboard/user/conversations/{id}",
 *           "security"= "is_granted('ROLE_USER')",
 *           "controller"="App\Controller\ConversationController::findConversationByUser", 
 * },
 * 
 *                  "dashboard/admin/conversations/{id}"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/conversations/{id}",
 *                  "security"= "is_granted('ROLE_ADMIN')", 
 *                  "normalization_context"={"groups"={"admin:conversid"}},                  
 *               }, 
 *          }
 * )
 * @ApiFilter(OrderFilter::class, properties= {"created_at": "ASC", "created_at": "DESC", "messages.created_at": "DESC", "messages.created_at": "ASC" })
 */
class Conversations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"conversations:collection", "userid:convers", "read:convuserid", "admin:conversid", "admin:conversationsid", "users:collection", "read:messages", "admin:conversations", "lastconversations:collection", "user:messages", "user:conversations", "admin:users", "user:conversid", "convmessage:create"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"conversations:collection", "read:convuserid", "admin:conversid", "user:conversid", "user:messages", "user:conversations", "admin:users"})
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=Messages::class, mappedBy="conversations")
     * @Groups({"conversations:item", "user:conversid", "user:conversations", "admin:conversationsid", "admin:conversid"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="conversations")
     * @Groups({"conversations:item", "read:convuserid", "read:conversationsid", "user:conversations", "admin:conversations", "admin:conversationsid", "lastconversations:collection", "admin:usersconv", "user:conversid"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $users;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Messages[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Messages $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setConversations($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getConversations() === $this) {
                $message->setConversations(null);
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
            $user->addConversation($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeConversation($this);
        }

        return $this;
    }
}
