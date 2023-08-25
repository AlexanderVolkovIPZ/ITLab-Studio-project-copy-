<?php

namespace App\Controller;

use App\Entity\CategoryHW;
use App\Entity\ProducerHW;
use App\Entity\ProductHW;
use App\Entity\User;
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
        $user = $this->getUser();
        if (in_array(User::ROLE_ADMIN, $user->getRoles())) {
            $requestData = json_decode($request->getContent(), true);

            if (!isset($requestData['name'], $requestData['count'], $requestData['price'], $requestData['imgName'], $requestData['category'], $requestData['producer'])) {
                throw new Exception("Invalid request data!");
            }
            $category = $this->entityManager->getRepository(CategoryHW::class)->find($requestData["category"]);

            if (!$category) {
                throw new Exception("Category with id " . $requestData['category'] . " not found");
            }

            $producer = $this->entityManager->getRepository(ProducerHW::class)->find($requestData["producer"]);

            if (!$producer) {
                throw new Exception("Producer with id " . $requestData['producer'] . " not found");
            }

            $product = new ProductHW();

            $product->setName($requestData['name'])
                ->setCount($requestData['count'])
                ->setPrice($requestData['price'])
                ->setImgName($requestData['imgName'])
                ->setCategory($category)
                ->setProducer($producer);

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return new JsonResponse($product->jsonSerialize(), Response::HTTP_CREATED);
        } else {
            return new JsonResponse("Access denied!");
        }
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
            $tmpResponce[] = $product->jsonSerialize();
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
            throw new Exception("Product not find!");
        }

        return new JsonResponse($product->jsonSerialize());
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/product-hw-update/{id}', name: 'product_hw_update')]
    public function update(string $id): JsonResponse
    {
        $user = $this->getUser();
        if (in_array(User::ROLE_ADMIN, $user->getRoles())) {
            $product = $this->entityManager->getRepository(ProductHW::class)->find($id);

            if (!$product) {
                throw new Exception("Product not find!");
            }

            $product->setName("devices");
            $this->entityManager->flush();

            return new JsonResponse($product);
        } else {
            return new JsonResponse("Access denied!");
        }
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/product-hw-delete/{id}', name: 'product_hw_delete')]
    public function delete(string $id): JsonResponse
    {
        $user = $this->getUser();
        if (in_array(User::ROLE_ADMIN, $user->getRoles())) {

            $product = $this->entityManager->getRepository(ProductHW::class)->find($id);

            if (!$product) {
                throw new Exception("Product not found!");
            }
            $this->entityManager->remove($product);
            $this->entityManager->flush();

            return new JsonResponse($product);
        } else {
            return new JsonResponse("Access denied!");
        }
    }

}