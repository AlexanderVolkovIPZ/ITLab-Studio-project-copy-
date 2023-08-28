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

class SumOrderValidator extends ConstraintValidator
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
        if (!$constraint instanceof SumOrder) {
            throw new UnexpectedTypeException($constraint, SumOrder::class);
        }

        if (!$value instanceof ContentOrderHW) {
            throw new UnexpectedTypeException($constraint, ContentOrderHW::class);
        }

        $sumCurrentItem = $value->getCount() * $this->entityManager->getRepository(ProductHW::class)->find($value->getProduct())->getPrice();

        $contentOrder = $this->entityManager->getRepository(ContentOrderHW::class)->findBy([
            "order" => $value->getOrder()
        ]);

        $sumOrder = 0;

        foreach ($contentOrder as $content) {
            $sumOrder += $content->getCount() * $this->entityManager->getRepository(ProductHW::class)->find($content->getProduct())->getPrice();
        }

        if ($sumOrder+$sumCurrentItem > 1000) {
            $this->context->addViolation("Error");
        }
    }
}