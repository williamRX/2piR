<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['order_details'])]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $total_price = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $creationDate = null;

    #[ORM\Column(length: 255)]
    private ?string $shipping_address = null;

    #[ORM\Column(length: 255)]
    #[Groups(['order_details'])]
    private ?string $shipping_city = null;
    
    #[ORM\ManyToOne(targetEntity: "App\Entity\User", inversedBy: "orders")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    #[Groups(['order_details'])]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $shipping_state = null;

    #[ORM\Column(length: 255)]
    private ?string $shipping_postal_code = null;

    #[ORM\Column(length: 255)]
    private ?string $shipping_country = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_method = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalPrice(): ?int
    {
        return $this->total_price;
    }

    public function setTotalPrice(int $total_price): static
    {
        $this->total_price = $total_price;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeImmutable
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeImmutable $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getShippingAdress(): ?string
    {
        return $this->shipping_address;
    }

    public function setShippingAdress(string $shipping_address): static
    {
        $this->shipping_address = $shipping_address;

        return $this;
    }

    public function getShippingCity(): ?string
    {
        return $this->shipping_city;
    }

    public function setShippingCity(string $shipping_city): static
    {
        $this->shipping_city = $shipping_city;

        return $this;
    }

    public function getShippingState(): ?string
    {
        return $this->shipping_state;
    }

    public function setShippingState(string $shipping_state): static
    {
        $this->shipping_state = $shipping_state;

        return $this;
    }

    public function getShppingPostalCode(): ?string
    {
        return $this->shipping_postal_code;
    }

    public function setShppingPostalCode(string $shipping_postal_code): static
    {
        $this->shipping_postal_code = $shipping_postal_code;

        return $this;
    }

    public function getShippingCountry(): ?string
    {
        return $this->shipping_country;
    }

    public function setShippingCountry(string $shipping_country): static
    {
        $this->shipping_country = $shipping_country;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(string $payment_method): static
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function getPaymentStatus(): ?string
    {
        return $this->payment_status;
    }

    public function setPaymentStatus(string $payment_status): static
    {
        $this->payment_status = $payment_status;

        return $this;
    }
    public function getUser(): ?User
    {
        return $this->user;
    }
    
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }
}
