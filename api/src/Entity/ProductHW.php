<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Action\CreateProductAction;
use App\EntityListener\ProductEntityListener;
use App\Repository\ProductHWRepository;
use App\Validator\Constraints\ProductCountPositive;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Finder\Iterator\DateRangeFilterIterator;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\UserHW;

#[ORM\Entity(repositoryClass: ProductHWRepository::class)]
#[ProductCountPositive]
#[ApiResource(
    collectionOperations: [
        "get" => [
            "method" => "GET",
            "normalization_context" => ["groups" => ["get:collection:product"]],
            "path" => "products"
        ],
        "post" => [
            "method" => "POST",
            "security" => "is_granted ('" . UserHW::ROLE_ADMIN . "')",
            "denormalization_context" => ["groups" => ["post:collection:product"]],
            "normalization_context" => ["groups" => ["get:collection:product"]],
            "controller" => CreateProductAction::class,
            "path" => "product-create"
        ]
    ],
    itemOperations: [
        "get" => [
            "method" => "GET",
            "normalization_context" => ["groups" => ["get:item:product"]]
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
#[ApiFilter(SearchFilter::class, properties: [
    "name" => "partial"
])]
#[ApiFilter(RangeFilter::class, properties: ['price'])]
#[ApiFilter(DateFilter::class, properties: ['date'])]
#[ORM\EntityListeners([ProductEntityListener::class])]
class ProductHW
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["get:item:product"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        "get:collection:product",
        "get:item:product",
        "post:collection:product"
    ])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(["get:item:product", "post:collection:product", "get:collection:product",])]
    private ?int $count = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    #[Groups(["get:item:product",
        "post:collection:product",
        "get:collection:product"
    ])]
    private ?string $price = null;

    #[Groups(["get:item:product",
        "post:collection:product"])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgName = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["get:item:product",
        "post:collection:product"])]
    private ?DateTime $date = null;

    #[ManyToOne(targetEntity: CategoryHW::class, inversedBy: "products")]
    #[Groups(["get:item:product",
        "post:collection:product"])]
    private ?CategoryHW $category = null;

    #[ManyToOne(targetEntity: UserHw::class, inversedBy: "products")]
    #[Groups(["get:item:product",
        "post:collection:product"])]
    private ?UserHW $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImgName(): ?string
    {
        return $this->imgName;
    }

    public function setImgName(?string $imgName): self
    {
        $this->imgName = $imgName;

        return $this;
    }

    public function getCategory(): ?CategoryHW
    {
        return $this->category;
    }

    public function setCategory(?CategoryHW $category): self
    {
        $this->category = $category;

        return $this;
    }
    /*    public function getContentOrder(): ?Collection
        {
            return $this->contentOrder;
        }

        public function setContentOrder(?Collection $contentOrder): self
        {
            $this->contentOrder = $contentOrder;

            return $this;
        }*/

    /*    public function jsonSerialize(): array
        {
            return [
                "id" => $this->getId(),
                "name" => $this->getName(),
                "count" => $this->getCount(),
                "price" => $this->getPrice(),
                "imgName" => $this->imgName,
            ];
        }*/

    public function getUser(): ?UserHW
    {
        return $this->user;
    }


    public function setUser(?UserHW $user): void
    {
        $this->user = $user;
    }

 /*   public function getDate()
    {
        return $this->date;
    }

    public function setDate(?string $date): void
    {
        $newDate = new DateTime($date);
        $this->date = $newDate->getTimestamp();
    }*/

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param DateTimeInterface $date
     * @return $this
     * @throws \Exception
     */
    public function setDate(DateTimeInterface $date): self
    {
        $this->date = new DateTime($date->format("Y-m-d H:i:s"));
        return $this;
    }
}