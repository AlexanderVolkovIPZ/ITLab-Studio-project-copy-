<?php

namespace App\Events;

use App\Entity\ProductHW;
use App\Entity\ProductHW as ProductHWAlias;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class ProductEvent
 * @package App\Events
 */
class ProductEvent extends Event
{
    public const PRODUCT_CREATE = 'product.create';

    /**
     * @var ProductHW
     */
    private ProductHWAlias $product;

    /**
     * @param ProductHW $product
     */
    public function __construct(ProductHW $product)
    {
        $this->product = $product;
    }

    /**
     * @return ProductHW
     */
    public function getProduct(): ProductHW
    {
        return $this->product;
    }
}
