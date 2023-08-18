<?php

namespace App\Entity;

use App\Repository\CustomerHWRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity(repositoryClass: CustomerHWRepository::class)]
class CustomerHW
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $middle_name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $mobile = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $city = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $address = null;

    /**
     * @var Collection|ArrayCollection|null
     */
    #[OneToMany(mappedBy: 'customer', targetEntity: OrderHW::class)]
    private ?Collection $orders;
    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return $this
     */
    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->middle_name;
    }

    /**
     * @param string $middle_name
     * @return $this
     */
    public function setMiddleName(string $middle_name): static
    {
        $this->middle_name = $middle_name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return $this
     */
    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     * @return $this
     */
    public function setMobile(string $mobile): static
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getOrders(): ?Collection
    {
        return $this->orders;
    }

    /**
     * @param Collection|null $orders
     * @return $this
     */
    public function setOrders(?Collection $orders): self
    {
        $this->orders = $orders;
        return $this;
    }
}
