<?php

namespace App\Entity;

use App\Repository\OrderHWRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use JsonSerializable;

#[ORM\Entity(repositoryClass: OrderHWRepository::class)]
class OrderHW implements JsonSerializable
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $count = null;

    /**
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $dateOrder = null;


    #[ManyToOne(targetEntity: User::class, inversedBy: "orders")]
    private ?User $user = null;

    /**
     * @var ProductHW|null
     */
    #[ManyToOne(targetEntity: ProductHW::class, inversedBy: "orders")]
    private ?ProductHW $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return $this
     */
    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDateOrder(): ?DateTimeInterface
    {
        return $this->dateOrder;
    }

    /**
     * @param DateTimeInterface $dateOrder
     * @return $this
     */
    public function setDateOrder(DateTimeInterface $dateOrder): self
    {
        $this->dateOrder = $dateOrder;

        return $this;
    }

    /**
     * @return ProductHW|null
     */
    public function getProduct(): ?ProductHW
    {
        return $this->product;
    }

    /**
     * @param ProductHW|null $product
     * @return $this
     */
    public function setProduct(?ProductHW $product): self
    {
        $this->product = $product;

        return $this;
    }
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
    public function jsonSerialize()
    {
        return [
            "id"=>$this->getId(),
            "count"=>$this->getCount(),
            "dateOrder"=>$this->getDateOrder(),
            "product"=>$this->getProduct(),
            "user"=>$this->getUser()
        ];
    }


}
