<?php

namespace App\Controller;

use App\Entity\CategoryHW;
use App\Entity\ProductHW;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductHWController extends AbstractController
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
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/product-hw-create', name: 'product_hw_create')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['name'], $requestData['count'], $requestData['price'], $requestData['imgName'], $requestData['category'])) {
            throw new Exception("Invalid request data!");
        }
        $category = $this->entityManager->getRepository(CategoryHW::class)->find($requestData["category"]);

        if (!$category) {
            throw new Exception("Category with id " . $requestData['category'] . " not found");
        }

        $product = new ProductHW();

        $product->setName($requestData['name'])
            ->setCount($requestData['count'])
            ->setPrice($requestData['price'])
            ->setImgName($requestData['imgName'])
            ->setCategory($category);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return new JsonResponse($product, Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/product-hw-read', name: 'product_hw_read')]
    public function read(Request $request): JsonResponse
    {
        $products = $this->entityManager->getRepository(ProductHW::class)->findAll();
        $tmpResponce = null;

        foreach ($products as $product) {
            $category = $this->entityManager->getRepository(CategoryHW::class)->find($product->getId());
            $tmpResponce[] = [
                "id" => $product->getId(),
                "name" => $product->getName(),
                "count" => $product->getCount(),
                "price" => $product->getPrice(),
                "imgName" => $product->getImgName(),
                "category" => [
                    "id" => $category->getId(),
                    "name" => $category->getName(),
                    "imgName" => $category->getImgName(),
                    "description" => $category->getDescription()
                ]
            ];
        }

        return new JsonResponse($tmpResponce);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/product-hw/{id}', name: 'product_hw_get_item')]
    public function getItem(string $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(ProductHW::class)->find($id);

        if (!$product) {
            throw new \Exception("Product not find!");
        } else {
            $category = $this->entityManager->getRepository(CategoryHW::class)->find($product->getCategory());
        }

        $tmpResponce = null;

        $tmpResponce[] = [
            "id" => $product->getId(),
            "name" => $product->getName(),
            "count" => $product->getCount(),
            "price" => $product->getPrice(),
            "imgName" => $product->getImgName(),
            "category" => [
                "id" => $category->getId(),
                "name" => $category->getName(),
                "imgName" => $category->getImgName(),
                "description" => $category->getDescription()
            ]
        ];

        return new JsonResponse($tmpResponce);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/product-hw-update/{id}', name: 'product_hw_update')]
    public function update(string $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(ProductHW::class)->find($id);

        if (!$product) {
            throw new \Exception("Product not find!");
        }

        $product->setName("devices");
        $this->entityManager->flush();

        return new JsonResponse($product);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/product-hw-delete/{id}', name: 'product_hw_delete')]
    public function delete(string $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(ProductHW::class)->find($id);

        if (!$product) {
            throw new Exception("Product not found!");
        }
        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return new JsonResponse($product);
    }

    #[Route('/find-product-by-filters', name: 'product_find_by_filters')]
    public function test(Request $request): JsonResponse
    {
        $requestDate = $request->query->all();

        $products = $this->entityManager->getRepository(ProductHW::class)
            ->getAllProductByNames(
                $requestDate['itemsPerPage'] ?? 20,
                $requestDate['page'] ?? 1,
                $requestDate['categoryName'] ?? null,
                $requestDate['name'] ?? null);
        return new JsonResponse($products);

    }
}