<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class CountProduct extends Constraint
{
    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return get_class($this) . "Validator";
    }

    /**
     * @return string|string[]
     */
    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}