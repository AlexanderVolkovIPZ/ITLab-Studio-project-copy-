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

class CategoryNameUniqueValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof CategoryNameUnique) {
            throw new UnexpectedTypeException($constraint, CategoryNameUnique::class);
        }

        if (!$value instanceof CategoryHW) {
            throw new UnexpectedTypeException($constraint, CategoryHW::class);
        }

        $countCategoryNames = count($this->entityManager->getRepository(CategoryHW::class)->findBy([
            'name'=>$value->getName()
        ]));

        if ($countCategoryNames) {
            $this->context->addViolation("Error! We already have such category name in category table!");
        }
    }
}