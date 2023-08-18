<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;


#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 2, scale: '0')]
    private ?string $price = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;
    #[ORM\ManyToOne(targetEntity: Category::class)]
    private ?Category $category = null;
//    #[ORM\OneToOne(targetEntity: ProductInfo::class)]
//    private ?ProductInfo $productInfo = null;

    #[ORM\ManyToMany(targetEntity: Test::class)]
    private Collection $test;
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return $this
     */
    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }



    public function jsonSerialize():array
    {
        return [
            "id"=>$this->getId(),
            "name"=>$this->getName(),
            "price"=>$this->getPrice(),
            "description"=>$this->getDescription(),
            "category"=>$this->getCategory()
        ];
    }


    /**
     * @param Category $category
     * @return void
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }


//    /**
//     * @return ProductInfo|null
//     */
//    public function getProductInfo(): ?ProductInfo
//    {
//        return $this->productInfo;
//    }

//    /**
//     * @param ProductInfo $productInfo
//     * @return $this
//     */
//    public function setProductInfo(ProductInfo $productInfo): self
//    {
//        $this->productInfo = $productInfo;
//        return $this;
//    }

    public function getTest(): Collection
    {
        return $this->test;
    }

    public function setTest(Collection $test): void
    {
        $this->test = $test;
    }
}