<?php

namespace App\Controller;

use App\Entity\CategoryHW;
use App\Entity\ProductHW;
use App\Entity\UserHW;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductHWController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var DenormalizerInterface
     */
    private DenormalizerInterface $denormalizer;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @param EntityManagerInterface $entityManager
     * @param DenormalizerInterface $denormalizer
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->denormalizer = $denormalizer;
        $this->validator = $validator;
    }

//    /**
//     * @param Request $request
//     * @return JsonResponse
//     * @throws Exception
//     */
//    #[Route('/product-hw-create', name: 'product_hw_create', methods: ["POST"])]
//    public function create(Request $request): JsonResponse
//    {
//        $user = $this->getUser();
//
//        if (!in_array(UserHW::ROLE_ADMIN, $user->getRoles())) {
//            throw new AccessDeniedException("Access denied!");
//        }
//        $requestData = json_decode($request->getContent(), true);
//
//        if (!isset($requestData['name'], $requestData['count'], $requestData['price'], $requestData['imgName'], $requestData['category'])) {
//            throw new Exception("Invalid request data!");
//        }
//        $category = $this->entityManager->getRepository(CategoryHW::class)->find($requestData["category"]);
//
//        if (!$category) {
//            throw new Exception("Category with id " . $requestData['category'] . " not found");
//        }
//
//        $product = $this->denormalizer->denormalize($requestData, ProductHW::class, "array");
//        $errors = $this->validator->validate($product);
//
//        if (count($errors) > 0) {
//            throw new Exception((string)$errors);
//        }
//
//        $product->setName($requestData['name'])
//            ->setCount($requestData['count'])
//            ->setPrice($requestData['price'])
//            ->setImgName($requestData['imgName'])
//            ->setCategory($category);
//
//        $this->entityManager->persist($product);
//        $this->entityManager->flush();
//
//        return new JsonResponse($product->jsonSerialize(), Response::HTTP_CREATED);
//    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/product-hw-read', name: 'product_hw_read', methods: ["GET"])]
    public function read(Request $request): JsonResponse
    {
        $products = $this->entityManager->getRepository(ProductHW::class)->findAll();
        $tmpResponce = null;

        foreach ($products as $product) {
            $tmpResponce[] = $product->jsonSerialize();
        }

        return new JsonResponse($tmpResponce, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/product-hw-get/{id}', name: 'product_hw_get_item', methods: ["GET"])]
    public function getItem(string $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(ProductHW::class)->find($id);

        if (!$product) {
            throw new NotFoundHttpException("Product with id = {$id} not found!");
        }

        return new JsonResponse($product->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/product-hw-update/{id}', name: 'product_hw_update', methods: ["PATCH"])]
    public function update(string $id, Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (!in_array(UserHW::ROLE_ADMIN, $user->getRoles())) {
            throw new AccessDeniedException("Access Denied!");
        }

        $product = $this->entityManager->getRepository(ProductHW::class)->find($id);

        if (!$product) {
            throw new NotFoundHttpException("Product not found!");
        }

        $requestData = json_decode($request->getContent(), true);

        if (isset($requestData['name'])) {
            $product->setName($requestData['name']);
        }

        if (isset($requestData['count'])) {
            $product->setCount($requestData['count']);
        }

        if (isset($requestData['price'])) {
            $product->setPrice($requestData['price']);
        }

        if (isset($requestData['imgName'])) {
            $product->setImgName($requestData['imgName']);
        }

        if (isset($requestData['category'])) {
            $category = $this->entityManager->getRepository(CategoryHW::class)->find($requestData['category']);
            isset($category) ? $product->setCategory($category) : throw new Exception("Invalid request data!");
        }

        $this->entityManager->flush();

        return new JsonResponse($product, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/product-hw-delete/{id}', name: 'product_hw_delete', methods: ["DELETE"])]
    public function delete(string $id): JsonResponse
    {
        $user = $this->getUser();

        if (!in_array(UserHW::ROLE_ADMIN, $user->getRoles())) {
            throw new AccessDeniedException("Access Denied!");
        }
        $product = $this->entityManager->getRepository(ProductHW::class)->find($id);

        if (!$product) {
            throw new NotFoundHttpException("Product not found!");
        }
        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return new JsonResponse($product, Response::HTTP_NO_CONTENT);
    }
}
