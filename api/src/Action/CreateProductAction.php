<?php

namespace App\Action;
use App\Entity\ProductHW;

class CreateProductAction
{
    /**
     * @param ProductHW $data
     * @return ProductHW
     */
    public function __invoke(ProductHW $data)
    {
        return $data;
    }
}
