<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryHWRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryHWRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" => [
            "method" => "GET",
            "security" => "is_granted ('" . UserHW::ROLE_USER . "') or is_granted ('" . UserHW::ROLE_ADMIN . "')"
        ],
        "POST" => [
            "method" => "POST",
            "security" => "is_granted ('" . UserHW::ROLE_ADMIN . "')"
        ]
    ],
    itemOperations: [
        "get" => [
            "method" => "GET",
            "security" => "is_granted ('" . UserHW::ROLE_USER . "') or is_granted ('" . UserHW::ROLE_ADMIN . "')"
        ],
        "put" => [
            'method' => 'PUT',
            'security' => "is_granted ('" . UserHW::ROLE_ADMIN . "')",
        ],
        "delete" => [
            'method' => 'DELETE',
            'security' => "is_granted ('" . UserHW::ROLE_ADMIN . "')",
        ],
    ], attributes: [
    "security" => "is_granted ('" . UserHW::ROLE_ADMIN . "') or is_granted ('" . UserHW::ROLE_USER . "')"
]
)]
class CategoryHW implements JsonSerializable
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
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min: 5)]
    private ?string $imgName = null;

    /**
     * CategoryHW constructor
     */
    public function __construct()
    {
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
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "imgName" => $this->getImgName()
        ];
    }
}
