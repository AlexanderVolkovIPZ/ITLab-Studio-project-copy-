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

#[ORM\Entity(repositoryClass: OrderHWRepository::class)]
class OrderHW
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
    private ?DateTimeInterface $date_order = null;

    /**
     * @var CustomerHW|null
     */
    #[ManyToOne(targetEntity: CustomerHW::class, inversedBy: "orders")]
    private ?CustomerHW $customer = null;

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
    public function setCount(int $count): static
    {
        $this->count = $count;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDateOrder(): ?DateTimeInterface
    {
        return $this->date_order;
    }

    /**
     * @param DateTimeInterface $date_order
     * @return $this
     */
    public function setDateOrder(DateTimeInterface $date_order): static
    {
        $this->date_order = $date_order;
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
}
