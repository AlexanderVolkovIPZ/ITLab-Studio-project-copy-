<?php

namespace App\Entity;

use App\Repository\CategoryHWRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity(repositoryClass: CategoryHWRepository::class)]
class CategoryHW
{
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
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img_name = null;
    /**
     * @var Collection|ArrayCollection|null
     */
    #[OneToMany(mappedBy: 'category', targetEntity: ProductHW::class)]
    private ?Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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
        return $this->img_name;
    }

    /**
     * @param string|null $img_name
     * @return $this
     */
    public function setImgName(?string $img_name): self
    {
        $this->img_name = $img_name;

        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getProducts(): ?Collection
    {
        return $this->products;
    }

    /**
     * @param Collection|null $products
     * @return $this
     */
    public function setProducts(?Collection $products): self
    {
        $this->products = $products;
        return $this;
    }
}
