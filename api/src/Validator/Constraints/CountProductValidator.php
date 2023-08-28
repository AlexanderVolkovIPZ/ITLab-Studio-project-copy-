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

class CountProductValidator extends ConstraintValidator
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
        if (!$constraint instanceof CountProduct) {
            throw new UnexpectedTypeException($constraint, CountProduct::class);
        }

        if (!$value instanceof ContentOrderHW) {
            throw new UnexpectedTypeException($constraint, ContentOrderHW::class);
        }

        $countProductCurrentItem = $value->getCount();

        $contentOrder = $this->entityManager->getRepository(ContentOrderHW::class)->findBy([
            "order" => $value->getOrder()
        ]);

        $countProductOrder = 0;

        foreach ($contentOrder as $content) {
            $countProductOrder += $content->getCount();
        }

        if ($countProductOrder + $countProductCurrentItem > 3) {
            $this->context->addViolation("Error! We already have 3 products in order!");
        }
    }
}