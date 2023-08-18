<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/test', name: 'test_test')]
    public function test(Request $request): JsonResponse
    {
        $requestDate = $request->query->all();

        $products = $this->entityManager->getRepository(Product::class)
            ->getAllProductByNames(
                $requestDate['itemsPerPage'] ?? 20,
                $requestDate['page'] ?? 1,
                $requestDate['categoryName'] ?? null,
                $requestDate['name'] ?? null);
        return new JsonResponse($products);

    }
}



