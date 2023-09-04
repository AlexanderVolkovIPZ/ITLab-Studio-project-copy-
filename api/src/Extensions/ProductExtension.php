<?php

namespace App\Extensions;

use App\Entity\ProductHW;
use Doctrine\ORM\QueryBuilder;

class ProductExtension extends UserRelationExtension
{
    /**
     * @return string
     */
    public function getResourceClass(): string
    {
        return ProductHW::class;
    }
}