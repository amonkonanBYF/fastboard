<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"ticket_read"}},
 *          },
 *
 *          "post"={"security"="is_granted('ROLE_ADMIN')", "security_message"="Only admins can add ticket."}
 *
 *     },
 *     itemOperations={
 *          "get"={
                "normalization_context"={"groups"={"ticket_details_read"}},
 *              "security"="is_granted('ROLE_USER') and object.owner == user or is_greated('ROLE_SERVEUR')", "security_message"="Sorry, but you are not the ticket owner.",
 *           },
 *          "put"={"security"="is_granted('ROLE_ADMIN','ROLE_SERVEUR')", "security_message"="Only admins and serveur can put ticket."},
 *          "patch"={"security"="is_granted('ROLE_ADMIN','ROLE_SERVEUR')", "security_message"="Only admins and serveur can put ticket."},
 *          "delete"
 *
 *     })
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 *
 * @ApiFilter(SearchFilter::class, properties={"valeurs": "exact"})
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups ({"ticket_read", "ticket_details_read"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups ({"ticket_read", "ticket_details_read"})
     */
    private string $valeurs;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups ({"ticket_read", "ticket_details_read"})
     */
    private string $lots;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *  @Groups ({"ticket_read", "ticket_details_read"})
     */
    private $createdAt;
    /**
     * @ORM\Column(type="boolean")
     *  @Groups ({"ticket_read", "ticket_details_read"})
     */
    private  $busy ;

    public function __construct()
    {
        $this->busy = false;
        $this->user = null;
    }
    /**
     * @return bool
     */
    public function isBusy(): bool
    {
        return $this->busy;
    }

    /**
     * @param bool $busy
     */
    public function setBusy(bool $busy): void
    {
        $this->busy = $busy;
    }



    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="userTicketAs")
     */
    private $user;

    public function getUser(): ?User
    {
        return $this->user;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeurs(): ?string
    {
        return $this->valeurs;
    }

    public function setValeurs(?string $valeurs): self
    {
        $this->valeurs = $valeurs;

        return $this;
    }

    public function getLots(): ?string
    {
        return $this->lots;
    }

    public function setLots(?string $lot): self
    {
        $this->lots = $lot;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    // public function generatedTicket($length_ticket, $permitted_chars) 
    // {
    //     $permitted_chars = '0123456789';
    //     $length_ticket = 1500000;
    //     $i = 0;
    //     $randArray = [];
    //     while( $i < $length_ticket) {
    //         $random = substr(str_shuffle($permitted_chars), 0, 10);
    //         $randArray[$i] = $random;
    //         $i++;
    //     }
    //     return $randArray;
    // }

}
