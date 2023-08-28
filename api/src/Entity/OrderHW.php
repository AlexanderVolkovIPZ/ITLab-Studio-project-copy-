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
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $dateOrder = null;

    /**
     * @var UserHW|null
     */
    #[ManyToOne(targetEntity: UserHW::class, inversedBy: "order")]
    private ?UserHW $user = null;

    #[OneToMany(mappedBy: 'order', targetEntity: ContentOrderHW::class)]
    private ?Collection $contentOrder;

    /**
     * OrderyHW constructor
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
     * @return UserHW|null
     */
    public function getUser(): ?UserHW
    {
        return $this->user;
    }

    /**
     * @param UserHW|null $user
     * @return $this
     */
    public function setUser(?UserHW $user): self
    {
        $this->user = $user;

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
            "dateOrder" => $this->getDateOrder(),
            "user"=>$this->getUser()
        ];
    }
}
