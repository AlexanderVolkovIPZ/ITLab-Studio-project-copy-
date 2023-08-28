<?php

namespace App\Entity;

use App\Repository\ProductHWRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductHWRepository::class)]
class ProductHW implements JsonSerializable
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Assert\Unique]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 3)]
    private ?string $name = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private ?int $count = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    #[Assert\NotBlank]
    private ?string $price = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min: 5)]
    private ?string $imgName = null;

    /**
     * @var CategoryHW|null
     */
    #[ManyToOne(targetEntity: CategoryHW::class, inversedBy: "products")]
    #[Assert\NotBlank]
    private ?CategoryHW $category = null;

    /**
     * @var Collection|ArrayCollection|null
     */
    #[OneToMany(mappedBy: 'product', targetEntity: ContentOrderHW::class)]
    #[Assert\NotBlank]
    private ?Collection $contentOrder;

    /**
     * ProductHW constructor
     */
    public function __construct()
    {
        $this->contentOrder = new ArrayCollection();
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImgName(): ?string
    {
        return $this->imgName;
    }

    /**
     * @param string|null $imgName
     * @return $this
     */
    public function setImgName(?string $imgName): self
    {
        $this->imgName = $imgName;

        return $this;
    }

    /**
     * @return CategoryHW|null
     */
    public function getCategory(): ?CategoryHW
    {
        return $this->category;
    }

    /**
     * @param CategoryHW|null $category
     * @return $this
     */
    public function setCategory(?CategoryHW $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getContentOrder(): ?Collection
    {
        return $this->contentOrder;
    }

    /**
     * @param Collection|null $contentOrder
     * @return $this
     */
    public function setContentOrder(?Collection $contentOrder): self
    {
        $this->contentOrder = $contentOrder;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "count" => $this->getCount(),
            "price" => $this->getPrice(),
            "imgName" => $this->imgName,
            "category" => $this->getCategory(),
        ];
    }
}
