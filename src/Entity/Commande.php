<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Eleve::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $par;

    /**
     * @ORM\ManyToOne(targetEntity=Eleve::class)
     */
    private $pour;

    /**
     * @ORM\Column(type="datetime")
     */
    private $orderDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valid;

    /**
     * @ORM\Column(type="boolean")
     */
    private $delivered;

    /**
     * @ORM\Column(type="string", length=511, nullable=true)
     */
    private $message;

    public function __construct()
    {
        $this->valid = false;
        $this->delivered = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPar(): ?Eleve
    {
        return $this->par;
    }

    public function setPar(?Eleve $par): self
    {
        $this->par = $par;

        return $this;
    }

    public function getPour(): ?Eleve
    {
        return $this->pour;
    }

    public function setPour(?Eleve $pour): self
    {
        $this->pour = $pour;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }

    public function getDelivered(): ?bool
    {
        return $this->delivered;
    }

    public function setDelivered(bool $delivered): self
    {
        $this->delivered = $delivered;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'from' => $this->par->getFullname(),
            'to' => $this->pour->getFullname(),
            'creationDate' => $this->orderDate->format("d/m/Y - H:i"),
            'msg' => $this->message,
            'valid' => $this->valid,
            'delivered' => $this->delivered,
        ];
    }
}
