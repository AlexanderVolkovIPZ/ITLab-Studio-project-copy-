<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/category_create', name: 'category_create')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['name'], $requestData['type'])) {
            throw new \Exception("Invalid request data");
        }

        $category = new Category();
        $category->setName($requestData['name']);
        $category->setType($requestData['type']);

        $this->entityManager->persist($category);
        $this->entityManager->flush();
        return new JsonResponse($category,Response::HTTP_CREATED);
    }

    #[Route('/product_read', name: 'product_read')]
    public function read(Request $request): JsonResponse
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        $tmpResponce = null;

        /** @var Product $product */
        foreach ($products as $product) {
            $tmpResponce[] = [
                "name" => $product->getName(),
                "price" => $product->getPrice(),
                "description" => $product->getDescription()
            ];
        }
        return new JsonResponse($tmpResponce);
    }

    #[Route('/product/{id}', name: 'product_get_item')]
    public function getItem(string $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw new \Exception("Product not find!");
        }
        return new JsonResponse($product);
    }

    #[Route('/product-update/{id}', name: 'product_update')]
    public function updateProduct(string $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw new \Exception("Product not find!");
        }

        $product->setName("New->product");
        $this->entityManager->flush();

        return new JsonResponse($product);
    }

    #[Route('/product-delete/{id}', name: 'product_delete')]
    public function deleteProduct(string $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw new \Exception("Product not find!");
        }
        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return new JsonResponse($product);
    }
}



