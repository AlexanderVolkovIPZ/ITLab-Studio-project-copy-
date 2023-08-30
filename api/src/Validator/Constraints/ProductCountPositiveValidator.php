<?php

namespace App\Validator\Constraints;

use App\Entity\CategoryHW;
use App\Entity\ContentOrderHW;
use App\Entity\OrderHW;
use App\Entity\ProductHW;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ProductCountPositiveValidator extends ConstraintValidator
{
    private const NUMBER = 0;

    /**
     * ProductCountPositiveValidator constructor
     */
    public function __construct()
    {
    }

    /**
     * @param $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ProductCountPositive) {
            throw new UnexpectedTypeException($constraint, ProductCountPositive::class);
        }

        if (!$value instanceof ProductHW) {
            throw new UnexpectedTypeException($constraint, ProductHW::class);
        }

        if()
        if ($value->getCount() < self::NUMBER) {
            $this->context->addViolation("Error! Count of product can't be less than 0!");
        }
    }
}