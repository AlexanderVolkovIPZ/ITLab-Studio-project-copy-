<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;


#[ORM\Entity()]
class ProductInfo implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;
//    #[ORM\OneToOne(mappedBy: "productInfo", targetEntity: Product::class)]
    //private Product $product;


    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @return array{id: int|null, name: null|string}
     */
    public function jsonSerialize()
    {
        return [
            "id"=>$this->getId(),
            "name"=>$this->getName()
        ];
    }

    /**
     * @return Product
     */
//    public function getProduct(): Product
//    {
//        return $this->product;
//    }
//
//    /**
//     * @param Product $product
//     * @return $this
//     */
//    public function setProduct(Product $product): self
//    {
//        $this->product = $product;
//        return $this;
//    }
}
