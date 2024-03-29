<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

// Ajout route personalisé ici (lastnewreservations, api_dashboard_user_payments, dashboard_user_properties, delete_user, api_sign_up) car pas possible à un autre endroit visiblement.

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Vich\Uploadable()
 * @ApiResource( normalizationContext={"groups"={"user:collection"}},
 *      denormalizationContext={"groups"={"user:write"}},
 *      paginationItemsPerPage= 20,
 *      paginationMaximumItemsPerPage= 20,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *              "api_register"={
 *                  "method"="POST",
 *                  "path"="register",
 *                  "deserialize" = false,
 *                  "controller"=App\Requests\Register::class,
 *                  "denormalization_context"={"groups"={"user:write"}},
 *                  "openapi_context" = {
 *                  "requestBody" = {
 *                     "content" = {
 *                         "multipart/form-data" = {
 *                             "schema" = {
 *                                 "type" = "object",
 *                                 "properties" = {
 *                                     "firstname" ={
 *                                        "type" = "string"
 *                                      },
 *                                     "lastname" ={
 *                                        "type" = "string"
 *                                      },
 *                                      "phone" ={
 *                                        "type" = "string"
 *                                      },
 *                                       "email" ={
 *                                        "type" = "string"
 *                                      },
 *                                       "address" ={
 *                                        "type" = "string"
 *                                      },
 *                                       "city" ={
 *                                        "type" = "string"
 *                                      }, 
 *                                       "birthdate" ={
 *                                        "type" = "date"
 *                                      },
 *                                       "zipCode" ={
 *                                        "type" = "string"
 *                                      }, 
 *                                       "country" ={
 *                                        "type" = "string"
 *                                      },
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
 *               }, 
 *                "dashboard/admin/users"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/users",
 *                  "normalization_context"={"groups"={"admin:users", "enable_max_depth"=true}},                 
 *               },                                 
 *          },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"user:collection", "user:item"}}},
 *          "put"={"security"= "is_granted('ROLE_USER')"},
 *          "patch"={},
 *          "delete"={},
 *               "api_dashboard_user_payments"={
 *                  "method"="GET",
 *                  "path"="/dashboard/user/{id}/payments",
 *                  "force_eager"=false,
 *                  "normalization_context"={"groups"={"read:payments", "enable_max_depth"=true}},    
 *               },
 *                 "dashboard_user_properties"={
 *                      "method"="GET",
 *                      "path"= "dashboard/user/{id}/properties",
 *                      "force_eager"=false,
 *                      "normalization_context"={"groups"={"user:properties", "enable_max_depth"=true}}
 *                 },               
 *               "api_dashboard_user_messages"={
 *                  "method"="GET",
 *                  "path"="/dashboard/user/{id}/messages",
 *                  "normalization_context"={"groups"={"read:messages"}},
 *               },
 *            
 *                 "dashboard/user/{id}/infos-personnelles"={
 *                  "method"="GET",
 *                  "path"="dashboard/user/{id}/infos-personnelles",
 *                  "normalization_context"={"groups"={"read:infosperso", "enable_max_depth"=true}},  
 *               },     
 *                  "dashboard/user/{id}/reservations"={
 *                  "method"="GET",
 *                  "path"="dashboard/user/{id}/reservations",
 *                  "normalization_context"={"groups"={"read:reservperso", "enable_max_depth"=true}},
 *               },    
 *                  "dashboard/user/{id}/comments"={
 *                  "method"="GET",
 *                  "path"="dashboard/user/{id}/comments",
 *                  "normalization_context"={"groups"={"read:commentsperso", "enable_max_depth"=true}},  
 *               },  
 *                  "dashboard/user/{id}/conversations"={
 *                  "method"="GET",
 *                  "path"="dashboard/user/{id}/conversations",
 *                  "security"= "is_granted('ROLE_USER')",
 *                  "controller"=App\Controller\FindConversationsByUser::class,
 *                  "normalization_context"={"groups"={"userid:convers", "enable_max_depth"=true}}, 
 *                  
 *               },  
 *  
 *                  "dashboard/user/{id}/reports"={
 *                  "method"="GET",
 *                  "path"="dashboard/user/{id}/reports",
 *                  "force_eager"=false,
 *                  "normalization_context"={"groups"={"read:reports", "enable_max_depth"=true}}, 
 *                  
 *               },  
 *                  "dashboard/owner/{id}/properties"={
 *                  "method"="GET",
 *                  "path"="dashboard/owner/{id}/properties",
 *                  "force_eager"=false,
 *                  "normalization_context"={"groups"={"owner:properties", "enable_max_depth"=true}}, 
 *                  
 *               },  
 *                  
 *                 
 *                  "dashboard/owner/{id}/reservations"={
 *                  "method"="GET",
 *                  "path"="dashboard/owner/{id}/reservations",
 *                  "force_eager"=false,
 *                  "security"= "is_granted('ROLE_OWNER')",
 *                  "normalization_context"={"groups"={"owner:reservations", "enable_max_depth"=true}},                  
 *               },
 * 
 *                  "dashboard/user/{id}/conversations"={
 *                  "method"="GET",
 *                  "path"="dashboard/user/{id}/conversations",
 *                  "security"= "is_granted('ROLE_USER')",
 *                    "controller"="App\Controller\ConversationController::findConversationByUser",                   
 *               }, 
 *  
 *                  "dashboard/admin/users/{id}"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/users/{id}",
 *                  "force_eager"=false,
 *                  "normalization_context"={"groups"={"admin:usersid", "admin:usertest", "enable_max_depth"=true}},
 *                  
 *               },  
 * 
 *                  "dashboard/admin/block-user/{id}"={
 *                  "method"="POST",
 *                  "path"="dashboard/admin/block-user/{id}", 
 *                  "security"= "is_granted('ROLE_ADMIN')",
 *                   "controller"="App\Controller\UserController::blockUser",
 *               },  
 *                  "dashboard/admin/deblock-user/{id}"={
 *                  "method"="POST",
 *                  "path"="dashboard/admin/deblock-user/{id}", 
 *                  "security"= "is_granted('ROLE_ADMIN')",
 *                  "controller"="App\Controller\UserController::deBlockUser",
 *               },  
 * 
 *                  "dashboard/user/modify-informations/{id}"={
 *                  "method"="POST",
 *                  "path"="dashboard/user/modify-informations/{id}", 
 *                  "security"= "is_granted('ROLE_USER')",
 *                  "controller"="App\Controller\UserController::modifyInformations",
 *               },  
 * 
 * 
 * 
 * 
 *                "dashboard/user/{id}/personal_informations/modifypassword"={
 *                  "method"="PATCH",
 *                  "deserialize" = false,
 *                  "security"= "is_granted('ROLE_USER')",
 *                  "path"="dashboard/user/{id}/personal_informations/modifypassword",
 *                  "controller"="App\Controller\ResetPassword::UpdatePwd",
 *                  "denormalization_context"={"groups"={"admin:useridentifiants", "enable_max_depth"=true}},
 *               },
 *      
 * 
 *           
 * 
 *                  "dashboard/update/profilepicture/user/{id}"={
 *                  "method"="POST",
 *                  "path"="dashboard/update/profilepicture/user/{id}",
 *                  "controller"=App\Controller\UpdateProfilePictureController::class,
 *                  "openapi_context" = {
 *                 "requestBody" = {
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
 *               }, 
 *                 
 *                    
 *                  
 *          }
 * )
 * @ApiFilter(SearchFilter::class, properties= {"properties.id": "exact", "properties.title": "exact", "lastname": "exact", "firstname" : "exact", "lastname": "partial", "firstname" : "partial"})
 * @ApiFilter(OrderFilter::class, properties= {"roles": "DESC", "roles": "ASC", "lastname": "ASC", "firstname" : "DESC", "reservations.comments.value": "ASC", "reservations.comments.value": "DESC", "created_at": "ASC", "created_at": "DESC"})
 * 
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:collection", "user:conversid", "read:commentsid", "read:reportsid", "read:reports", "admin:reports", "admin:reportsid", "read:reportsid", "admin:reportsid", "admin:conversid", "propertiesid:item", "user:write", "admin:usersconv", "admin:usersid", "propertiesid:item", "reservations:user", "user:conversations", "admin:reports", "admin:reportsid", "admin:commentsid", "lastcomments:collection", "properties:item", "read:infosperso", "admin:users", "owner:read", "owner:reservid", "user:messages", "read:messages", "reservations:user", "user:comments", "user:reports", "user:createreservations", "usermessage:create"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:collection", "user:write", "admin:usersid", "read:infosperso", "users:login"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:item", "admin:usersid", "admin:users", "user:write"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user:write", "users:login", "admin:useridentifiants"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"comments:item", "user:conversid", "read:commentsid", "read:reportsid", "read:reports", "admin:reports", "admin:reportsid", "read:reportsid", "admin:conversid", "admin:reportsid", "user:write", "propertiesid:item", "admin:usersconv", "admin:usersid", "propertiesid:item", "reservations:user", "user:conversations", "admin:reportsid", "admin:reports", "admin:commentsid", "reservations:item", "reservations:user", "properties:item", "admin:users", "owner:reservid", "read:infosperso", "payments:item", "user:item", "user:messages", "read:messages", "conversations:item", "lastcomments:collection", "users:register"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=15)
     * @Groups({"user:item", "user:write", "read:infosperso", "admin:usersid"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:item", "user:write", "read:infosperso", "admin:usersid"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:item", "user:write", "read:infosperso", "admin:usersid"})
     */
    private $city;

    /**
     * @ORM\Column(type="date")
     * @Groups({"user:item", "user:write", "read:infosperso", "admin:usersid"})
     */
    private $birthdate;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"user:item", "user:write", "read:infosperso", "admin:usersid"})
     */
    private $zipCode;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"user:item", "admin:usersid"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"user:item", "admin:usersid"})
     */
    private $updated_at;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user:item", "admin:usersid"})
     */
    private $emailvalidated;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"comments:item", "user:conversid", "read:commentsid", "read:reportsid", "read:reports", "user:conversid", "admin:reports", "admin:reportsid", "read:reportsid", "admin:conversid", "admin:reportsid", "user:write", "user:conversid", "propertiesid:item", "admin:usersconv", "admin:usersid", "propertiesid:item", "user:conversations", "admin:reports", "admin:reportsid", "admin:commentsid", "reservations:item", "properties:item", "admin:users", "owner:reservid", "read:infosperso", "payments:item", "user:item", "user:messages", "read:messages", "conversations:item", "lastcomments:collection", "users:register"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:item", "user:write", "read:infosperso", "admin:usersid"})
     */
    private $country;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="user_images", fileNameProperty="picture")
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filePath;

    /**
     * @var string|null
     * @Groups({"user:item", "properties:write"})
     */
    private $fileUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:collection", "user:conversid", "comments:item", "read:commentsid", "read:reportsid", "read:reports", "user:conversid", "admin:reports", "admin:reportsid", "read:reportsid", "admin:conversid", "admin:reportsid", "user:write", "user:conversid", "admin:usertest", "propertiesid:item", "admin:usersconv", "admin:usersid", "propertiesid:item", "reservations:user", "user:conversations", "admin:reports", "admin:reportsid", "admin:commentsid", "reservations:item", "reservations:user", "properties:item", "admin:users", "owner:reservid", "read:infosperso", "payments:item", "user:item", "conversations:item", "user:messages", "lastcomments:collection", "users:register"})
     */
    private $picture;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user:item", "admin:usersid"})
     */
    private $is_blocked;


    /**
     * @ORM\OneToMany(targetEntity=Properties::class, mappedBy="user"))
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @Groups({"user:properties", "owner:properties", "admin:proequip", "admin:usersid"})
     */
    private $properties;

    /**
     * @ORM\OneToMany(targetEntity=Reservations::class, mappedBy="user"))
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @Groups({"user:item", "user:reservations", "read:reservations", "read:reservperso", "admin:reservations", "owner:reservations"})
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="user"))
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @Groups({"read:commentsperso"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Payments::class, mappedBy="user"))
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @Groups({"read:payments"})
     */
    private $payments;

    /**
     * @ORM\OneToMany(targetEntity=Messages::class, mappedBy="user"))
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE") 
     * @Groups({"read:messages"})
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity=Conversations::class, inversedBy="users"))
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE") 
     * @Groups({"user:conversations", "userid:convers"})
     */
    private $conversations;

    /**
     * @ORM\OneToMany(targetEntity=Reports::class, mappedBy="user"))
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE") 
     * @Groups({"read:reports"})
     */
    private $reports;




    public function __construct()
    {
        $this->properties = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->payments = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->conversations = new ArrayCollection();
        $this->reports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getEmailvalidated(): ?bool
    {
        return $this->emailvalidated;
    }

    public function setEmailvalidated(?bool $emailvalidated): self
    {
        $this->emailvalidated = $emailvalidated;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

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
     * @return User
     */
    public function setFile(?File $file): User
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
     * @return User
     */
    public function setFileUrl(?string $fileUrl): User
    {
        $this->fileUrl = $fileUrl;
        return $this;
    }


    public function getIsBlocked(): ?bool
    {
        return $this->is_blocked;
    }

    public function setIsBlocked(?bool $is_blocked): self
    {
        $this->is_blocked = $is_blocked;

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
            $property->setUser($this);
        }

        return $this;
    }

    public function removeProperty(Properties $property): self
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getUser() === $this) {
                $property->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reservations[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservations $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setUser($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getUser() === $this) {
                $reservation->setUser(null);
            }
        }

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
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Payments[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payments $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setUser($this);
        }

        return $this;
    }

    public function removePayment(Payments $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getUser() === $this) {
                $payment->setUser(null);
            }
        }

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
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Conversations[]
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversations $conversation): self
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations[] = $conversation;
        }

        return $this;
    }

    public function removeConversation(Conversations $conversation): self
    {
        $this->conversations->removeElement($conversation);

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
            $report->setUser($this);
        }

        return $this;
    }

    public function removeReport(Reports $report): self
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getUser() === $this) {
                $report->setUser(null);
            }
        }

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
}
