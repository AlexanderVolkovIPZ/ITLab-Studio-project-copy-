<?php

namespace App\Controller;

use App\Entity\CategoryHW;
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

class CategoryHWController extends AbstractController
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

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/category-hw-create', name: 'category_hw_create', methods: ["POST"])]
    public function create(Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (!in_array(UserHW::ROLE_ADMIN, $user->getRoles())) {
            throw new AccessDeniedException("Access Denied!");
        }

        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['imgName'], $requestData['name'])) {
            throw new Exception("Invalid request data");
        }

        $category = $this->denormalizer->denormalize($requestData, CategoryHW::class, "array");
        $errors = $this->validator->validate($category);
        if(count($errors)>0){
            throw new Exception((string)$errors);
        }

        $category->setName($requestData['name'])->setImgName($requestData['imgName']);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return new JsonResponse($category->jsonSerialize(), Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/category-hw-read', name: 'category_hw_read', methods: ["GET"])]
    public function read(Request $request): JsonResponse
    {
        $categories = $this->entityManager->getRepository(CategoryHW::class)->findAll();
        $tmpResponce = null;

        foreach ($categories as $category) {
            $tmpResponce[] = $category->jsonSerialize();
        }

        return new JsonResponse($tmpResponce, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/category-hw-get/{id}', name: 'category_hw_get', methods: ['GET'])]
    public function getItem(string $id): JsonResponse
    {
        $category = $this->entityManager->getRepository(CategoryHW::class)->find($id);

        if (!$category) {
            throw new NotFoundHttpException("Category with id = {$id} not found!");
        }

        return new JsonResponse($category->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/category-hw-update/{id}', name: 'category_hw_update', methods: ['PATCH'])]
    public function update(string $id, Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (!in_array(UserHW::ROLE_ADMIN, $user->getRoles())) {
            throw new AccessDeniedException("Access Denied!");
        }

        $category = $this->entityManager->getRepository(CategoryHW::class)->find($id);

        if (!$category) {
            throw new NotFoundHttpException("Category not found!");
        }

        $requestData = json_decode($request->getContent(), true);

        if (isset($requestData['name'])) {
            $category->setName($requestData['name']);
        }

        if (isset($requestData['imgName'])) {
            $category->setImgName($requestData['imgName']);
        }

        $this->entityManager->flush();

        return new JsonResponse($category, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/category-hw-delete/{id}', name: 'category_hw_delete', methods: ["DELETE"])]
    public function delete(string $id): JsonResponse
    {
        $user = $this->getUser();

        if (!in_array(UserHW::ROLE_ADMIN, $user->getRoles())) {
            throw new AccessDeniedException("Access Denied!");
        }
        $category = $this->entityManager->getRepository(CategoryHW::class)->find($id);

        if (!$category) {
            throw new NotFoundHttpException("Category not found!");
        }
        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return new JsonResponse($category, Response::HTTP_NO_CONTENT);
    }
}