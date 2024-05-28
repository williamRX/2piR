<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    // #[Groups(['user_details'])]
    #[Groups(['order_details'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user_details'])]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user_details'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user_details'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user_details'])]
    private ?string $lastname = null;

    #[ORM\Column]
    #[Groups(['user_details'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: ProductCart::class)]
    #[Groups(['user_details'])]
    private Collection $productCarts;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: Order::class)]
    #[Groups(['user_details'])]
    private Collection $orders;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: ProductWishlist::class)]
    #[Groups(['user_details'])]
    private Collection $productWishlists;

    public function __construct()
    {
        $this->productCarts = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->productWishlists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getProductCarts(): Collection
    {
        return $this->productCarts;
    }

    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function getProductWishlists(): Collection
    {
        return $this->productWishlists;
    }

    public function getRoles(): array
    {
        if ($this->username === "admin") {
            return ['ROLE_ADMIN'];
        } else { 
            return ['ROLE_USER'];
        }
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function generateToken(): string
    {
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded($_ENV['JWT_SECRET_KEY']) // Use environment variable for key
        );

        $now   = new \DateTimeImmutable();
        $token = $config->builder()
                        ->issuedBy('http://localhost:8000')
                        ->permittedFor('http://localhost:8000') 
                        ->identifiedBy('4f1g23a12aa', true) 
                        ->issuedAt($now)
                        ->canOnlyBeUsedAfter($now->modify('+1 minute'))
                        ->expiresAt($now->modify('+1 hour'))
                        ->withClaim('uid', $this->getId())
                        ->getToken($config->signer(), $config->signingKey());

        return $token->toString();
    }
    public function addProductCart(ProductCart $productCart): static
    {
        if (!$this->productCarts->contains($productCart)) {
            $this->productCarts[] = $productCart;
            $productCart->setUser($this);
        }
        return $this;
    }
    public function removeProductCart(ProductCart $productCart): static
    {
        if ($this->productCarts->removeElement($productCart)) {
            if ($productCart->getUser() === $this) {
                $productCart->setUser(null);
            }
        }
        return $this;
    }
    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }
        return $this;
    }
}
