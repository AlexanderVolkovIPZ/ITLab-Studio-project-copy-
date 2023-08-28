<?php

namespace App\Validator\Constraints;

use App\Entity\ContentOrderHW;
use App\Entity\OrderHW;
use App\Entity\ProductHW;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class CountOrderValidator extends ConstraintValidator
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
        if (!$constraint instanceof CountOrder) {
            throw new UnexpectedTypeException($constraint, CountOrder::class);
        }

        if (!$value instanceof OrderHW) {
            throw new UnexpectedTypeException($constraint, OrderHW::class);
        }

        $orders = $this->entityManager->getRepository(OrderHW::class)->findBy([
            'user'=>$value->getUser()
        ]);

        if (count($orders) == 2) {
            $this->context->addViolation("Error");
        }
    }
}