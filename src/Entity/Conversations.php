<?php

namespace App\Entity;

use App\Repository\ConversationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use \DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

//Ajout route dashboard/user/conversations/details/{id}/create
/**
 * @ORM\Entity(repositoryClass=ConversationsRepository::class)
 * @ApiResource( normalizationContext={"groups"={"conversations:collection"}},
 *      denormalizationContext={"groups"={"conversations:write"}},
 *      paginationItemsPerPage= 20,
 *      paginationMaximumItemsPerPage= 20,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},             
 *            
 * 
 *                  "dashboard/admin/conversations"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/conversations",
<<<<<<< HEAD
 *                   "controller"=App\Controller\LastNewConversations::class,
 *                  
 *               }, 
 *                 
=======
<<<<<<< HEAD
 *                  "controller"=App\Controller\LastNewConversations::class,
 *                  
 *               },  
=======
 *                   "controller"=App\Controller\LastNewConversations::class,
 *                  
 *               },   
>>>>>>> master
>>>>>>> master
 *             
 *          },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"conversations:collection", "conversations:item"}}},
 *          "put"={},
 *          "delete"={},            
 *               "dashboard/user/conversations/{id}"={
 *                  "method"="GET",
 *                  "path"="dashboard/user/conversations/{id}",
 *                  "controller"=App\Controller\FindConversationsidByUser::class,
 *                  
 *               }, 
 *                  "dashboard/admin/conversations/{id}"={
 *                  "method"="GET",
<<<<<<< HEAD
 *                  "path"="dashboard/admin/conversations/{id}", 
=======
 *                  "path"="dashboard/admin/conversations/{id}",  
>>>>>>> master
 *                  "controller"=App\Controller\AllConversations::class,
 *                  
 *               }, 
 *          }
 * )
 */
class Conversations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
<<<<<<< HEAD
     * @Groups({"conversations:collection", "user:conversid", "read:messages", "user:messages", "user:conversations", "admin:users"})
=======
<<<<<<< HEAD
<<<<<<< HEAD
     * @Groups({"conversations:collection", "user:conversid", "read:messages", "user:messages", "user:conversations", "admin:users"})
=======
     * @Groups({"conversations:collection", "admin:conversationsid", "users:collection", "read:messages", "admin:conversations", "lastconversations:collection", "user:messages", "user:conversations", "admin:users"})
>>>>>>> master
=======
     * @Groups({"conversations:collection", "admin:conversationsid", "users:collection", "read:messages", "admin:conversations", "lastconversations:collection", "user:messages", "user:conversations", "admin:users", "user:conversid", "convmessage:create"})
>>>>>>> master
>>>>>>> master
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"conversations:collection", "user:conversid", "user:messages", "user:conversations", "admin:users"})
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=Messages::class, mappedBy="conversations")
<<<<<<< HEAD
     * @Groups({"conversations:item", "user:conversid", "admin:conversationsid","user:conversations"})
=======
<<<<<<< HEAD
<<<<<<< HEAD
     * @Groups({"conversations:item", "user:conversid", "user:conversations"})
=======
     * @Groups({"conversations:item", "admin:conversationsid", "user:conversations"})
>>>>>>> master
=======
     * @Groups({"conversations:item", "user:conversid", "user:conversations", "admin:conversationsid"})
>>>>>>> master
>>>>>>> master
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="conversations")
<<<<<<< HEAD
     * @Groups({"conversations:item", "read:conversationsid", "user:conversations", "admin:conversations", "admin:conversationsid", "lastconversations:collection", "admin:usersconv"})
=======
<<<<<<< HEAD
<<<<<<< HEAD
     * @Groups({"conversations:item", "user:conversations", "admin:usersconv", "user:conversid"})
=======
     * @Groups({"conversations:item", "read:conversationsid", "user:conversations", "admin:conversations", "admin:conversationsid", "lastconversations:collection", "admin:usersconv"})
>>>>>>> master
=======
     * @Groups({"conversations:item", "read:conversationsid", "user:conversations", "admin:conversations", "admin:conversationsid", "lastconversations:collection", "admin:usersconv", "user:conversid"})
>>>>>>> master
>>>>>>> master
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
