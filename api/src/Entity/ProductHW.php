<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductHWRepository;
use App\Validator\Constraints\ProductCountPositive;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductHWRepository::class)]
#[ProductCountPositive]
#[ApiResource(
    collectionOperations: [
        "get" => [
            "method" => "GET",
        ],
        "post" => [
            "method" => "POST",
            "security" => "is_granted ('" . UserHW::ROLE_ADMIN . "')"
        ]
    ],
    itemOperations: [
        "get" => [
            "method" => "GET",
        ],
        "put" => [
            'method' => 'PUT',
            'security' => "is_granted ('" . UserHW::ROLE_ADMIN . "')",
        ],
        "delete" => [
            'method' => 'DELETE',
            'security' => "is_granted ('" . UserHW::ROLE_ADMIN . "')",
        ],
    ],
    attributes: [
        "security" => "is_granted ('" . UserHW::ROLE_ADMIN . "') or is_granted ('" . UserHW::ROLE_USER . "')"
    ]
)]
class ProductHW implements JsonSerializable
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
    private ?string $name = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $count = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $price = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgName = null;

    /*    #[ManyToOne(targetEntity: CategoryHW::class, inversedBy: "products")]
        #[Assert\NotBlank]
        private ?CategoryHW $category = null;*/

    /*    #[OneToMany(mappedBy: 'product', targetEntity: ContentOrderHW::class)]
        #[Assert\NotBlank]
        private ?Collection $contentOrder;*/

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

    /*    public function getCategory(): ?CategoryHW
        {
            return $this->category;
        }

        public function setCategory(?CategoryHW $category): self
        {
            $this->category = $category;

            return $this;
        }*/

    /*    public function getContentOrder(): ?Collection
        {
            return $this->contentOrder;
        }

        public function setContentOrder(?Collection $contentOrder): self
        {
            $this->contentOrder = $contentOrder;

            return $this;
        }*/

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
/*            "category" => $this->getCategory(),*/
        ];
    }
}
