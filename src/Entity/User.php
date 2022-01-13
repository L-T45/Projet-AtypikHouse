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

// Ajout route personalisé ici (lastnewreservations, api_dashboard_user_payments, dashboard_user_properties, delete_user, api_sign_up) car pas possible à un autre endroit visiblement.

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *  @ApiResource( normalizationContext={"groups"={"user:collection"}},
 *      denormalizationContext={"groups"={"user:write"}},
 *      paginationItemsPerPage= 20,
 *      paginationMaximumItemsPerPage= 20,
 *      paginationClientItemsPerPage= true,
 *      collectionOperations={
 *            "get"={},
 *            "post"={},
 *                "api_send_payment"={
 *                  "method"="POST",
 *                  "path"="/send_payment",
 *                  "controller"=App\Controller\SendPayment::class 
 *               }, 
 *                 "dashboard/admin/users"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/users",
 *                  "normalization_context"={"groups"={"admin:users", "enable_max_depth"=true}},                 
 *               },            
 *          },
 *      itemOperations={
 * 
 *          "get"={"normalization_context"={"groups"={"user:collection", "user:item"}}},
 *          "put"={},
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
 *                 
 *                  "delete_user"={
 *                     "method"="DELETE",
 *                     "path"="dashboard/user/{id}/personnal-infos/delete-account",
 *                 },
 *                  
 *               "api_dashboard_user_messages"={
 *                  "method"="GET",
 *                  "path"="/dashboard/user/{id}/messages",
 *                  "normalization_context"={"groups"={"read:messages"}},
 *                 
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
 *                  "force_eager"=false,
 *                  "normalization_context"={"groups"={"user:conversations", "enable_max_depth"=true}}, 
 *                  
 *               },  
 *                  "dashboard/user/{id}/reports"={
 *                  "method"="GET",
 *                  "path"="dashboard/user/{id}/reports",
 *                  "normalization_context"={"groups"={"read:reports", "enable_max_depth"=true}}, 
 *                  
 *               },  
 *                  "dashboard/owner/{id}/properties"={
 *                  "method"="GET",
 *                  "path"="dashboard/owner/{id}/properties",
 *                  "normalization_context"={"groups"={"owner:properties", "enable_max_depth"=true}}, 
 *                  
 *               },  
 *                  
 *                 
 *                  "dashboard/owner/{id}/reservations"={
 *                  "method"="GET",
 *                  "path"="dashboard/owner/{id}/reservations",
 *                  "normalization_context"={"groups"={"owner:reservations", "enable_max_depth"=true}},
 *                  
 *               },  
 *                  "dashboard/admin/users/{id}"={
 *                  "method"="GET",
 *                  "path"="dashboard/admin/users/{id}",
 *                  "normalization_context"={"groups"={"admin:usersid", "admin:usersconv", "enable_max_depth"=true}},
 *                  
 *               },  
 *                 
 *                  
 *          }
 * )
 * @ApiFilter(SearchFilter::class, properties= {"properties.id": "exact", "lastname": "exact"})
 * @ApiFilter(DateFilter::class, properties= {"reservations.startdate"})
 * @ApiFilter(OrderFilter::class, properties= {"id": "DESC", "price": "ASC", "price": "DESC", "reservations.comments.value": "ASC", "reservations.comments.value": "DESC"})
 * 
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:collection", "user:write", "admin:usersconv", "admin:usersid", "propertiesid:item", "reservations:user", "user:conversations", "admin:reports", "admin:reportsid", "admin:commentsid", "lastcomments:collection", "properties:item", "read:infosperso", "admin:users", "owner:read", "owner:reservid", "user:messages", "read:messages", "reservations:user"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:collection", "user:write", "admin:usersid", "read:infosperso"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:item", "admin:usersid", "user:write"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user:write"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"comments:item", "user:write", "admin:usersconv", "admin:usersid", "propertiesid:item", "reservations:user", "user:conversations", "admin:reportsid", "admin:reports", "admin:commentsid", "reservations:item", "reservations:user", "properties:item", "admin:users", "owner:reservid", "read:infosperso", "payments:item", "user:item", "user:messages", "read:messages", "conversations:item", "lastcomments:collection"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="integer")
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
     * @Groups({"comments:item", "user:write", "admin:usersconv", "admin:usersid", "propertiesid:item", "user:conversations", "admin:reports", "admin:reportsid", "admin:commentsid", "reservations:item", "properties:item", "admin:users", "owner:reservid", "read:infosperso", "payments:item", "user:item", "user:messages", "read:messages", "conversations:item", "lastcomments:collection"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:item", "user:write", "read:infosperso", "admin:usersid"})
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"comments:item", "user:write", "admin:usersconv", "admin:usersid", "propertiesid:item", "reservations:user", "user:conversations", "admin:reports", "admin:reportsid", "admin:commentsid", "reservations:item", "reservations:user", "properties:item", "admin:users", "owner:reservid", "read:infosperso", "payments:item", "user:item", "conversations:item", "user:messages", "lastcomments:collection"})
     */
    private $picture;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user:item", "admin:usersid"})
     */
    private $is_blocked;


    /**
     * @ORM\OneToMany(targetEntity=Properties::class, mappedBy="user")
     * @Groups({"user:properties", "owner:properties", "admin:proequip", "admin:usersid"})
     */
    private $properties;

    /**
     * @ORM\OneToMany(targetEntity=Reservations::class, mappedBy="user")
     * @Groups({"user:item", "user:reservations", "admin:usersid", "read:reservations", "read:reservperso", "admin:reservations", "owner:reservations"})
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="user")
     * @Groups({"read:commentsperso"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Payments::class, mappedBy="user")
     * @Groups({"read:payments"})
     */
    private $payments;

    /**
     * @ORM\OneToMany(targetEntity=Messages::class, mappedBy="user")
     * @Groups({"read:messages", "admin:usersid"})
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity=Conversations::class, inversedBy="users")
     * @Groups({"user:conversations"})
     */
    private $conversations;

    /**
     * @ORM\OneToMany(targetEntity=Reports::class, mappedBy="user")
     * @Groups({"read:reports", "admin:users"})
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
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
}
