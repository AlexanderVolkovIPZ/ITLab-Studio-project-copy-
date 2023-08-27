<?php

namespace App\Entity;

use App\Repository\ContentOrderHWRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use JsonSerializable;

#[ORM\Entity(repositoryClass: ContentOrderHWRepository::class)]
class ContentOrderHW implements JsonSerializable
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
     * @var ProductHW|null
     */
    #[ManyToOne(targetEntity: ProductHW::class, inversedBy: "contentOrder")]
    private ?ProductHW $product = null;

    /**
     * @var OrderHW|null
     */
    #[ManyToOne(targetEntity: OrderHW::class, inversedBy: "contentOrder")]
    private ?OrderHW $order = null;

    /**
     * @return int|null
     */
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

    /**
     * @return OrderHW|null
     */
    public function getOrder(): ?OrderHW
    {
        return $this->order;
    }

    /**
     * @param OrderHW|null $order
     * @return $this
     */
    public function setOrder(?OrderHW $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            "id" => $this->getId(),
            "count" =>$this->getCount(),
            "order"=>$this->getProduct(),
            "product"=>$this->getProduct()
        ];
    }
}
