<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;




/**
 * @ApiResource(
 *       attributes={
 *              "input_formats"={"json"={"application/ld+json", "application/json"}},
 *              "output_formats"={"json"={"application/ld+json", "application/json"}}
 *          },
 *     collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"user_read"}},
 *          },
 *          "post"
 *     },
 *     itemOperations={
 *          "get"={
                "normalization_context"={"groups"={"user_details_read"}},

 *           },
 *
 *          "put"={"security"="is_granted('ROLE_ADMIN')", "security_message"="Only admins can put user."},
 *          "patch",
 *          "delete"={"security"="is_granted('ROLE_ADMIN')", "security_message"="Only admins can delete user."}
 *
 *     }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups ({"user_read", "user_details_read"})
     */
    
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups ({"user_read", "user_details_read"})

     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups ({"user_read", "user_details_read"})

     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     *
     * @Groups ({"user_read", "user_details_read"})

     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     *
     *
     * @Groups ({"user_read", "user_details_read"})

     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=6)
     * @Groups ("user:write")
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     * @Groups ("user:read")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     *
     * @Groups ({"user_read", "user_details_read"})
     */
    private $dateCreated;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ticket", inversedBy="user")
     */
    private $userTicketAs;
    
    /**
     *  @ORM\Column(type="string", nullable=true)
     */
    private $userTicketValue;
    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups ({"user_read", "user_details_read"})
     */
    private  $newsLetter;

    public function __construct()
    {
        $this->newsLetter = false;
    }

    /**
     * @return mixed
     */
    public function getNewsLetter()
    {
        return $this->newsLetter;
    }

    /**
     * @param mixed $newsLetter
     */
    public function setNewsLetter($newsLetter): void
    {
        $this->newsLetter = $newsLetter;
    }


    public function getUserTicketValue(): ?string
     {
		return $this->userTicketValue;
     }

    /**
     * @return Collection|Ticket[]
     */
     public function getUserTicketAs(): ?Collection
     {
		return $this->userTicketAs;
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }
    public function addTicket(int $userTicketAs)
    {
        return $userTicketAs;
    }

}
