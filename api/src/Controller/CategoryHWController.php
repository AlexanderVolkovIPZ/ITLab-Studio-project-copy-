<?php

namespace App\Controller;

use App\Entity\CategoryHW;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryHWController extends AbstractController
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
    #[Route('/category-hw-create', name: 'category_hw_create')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['imgName'], $requestData['name'])) {
            throw new Exception("Invalid request data");
        }

        $category = new CategoryHW();
        $category->setName($requestData['name'])->setImgName($requestData['imgName']);
        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return new JsonResponse($category, Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/category-hw-read', name: 'category_hw_read')]
    public function read(Request $request): JsonResponse
    {
        $categories = $this->entityManager->getRepository(CategoryHW::class)->findAll();
        $tmpResponce = null;

        foreach ($categories as $category) {
            $tmpResponce[] = [
                "id" => $category->getId(),
                "name" => $category->getName(),
                "imgName" => $category->getImgName()
            ];
        }

        return new JsonResponse($tmpResponce);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws \Exception
     */
    #[Route('/category-hw/{id}', name: 'category_hw_get_item')]
    public function getItem(string $id): JsonResponse
    {
        $category = $this->entityManager->getRepository(CategoryHW::class)->find($id);

        if (!$category) {
            throw new \Exception("Product not find!");
        }

        return new JsonResponse($category);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws \Exception
     */
    #[Route('/category-hw-update/{id}', name: 'category_hw_update')]
    public function update(string $id): JsonResponse
    {
        $category = $this->entityManager->getRepository(CategoryHW::class)->find($id);

        if (!$category) {
            throw new \Exception("Category not find!");
        }

        $category->setName("планшети");
        $this->entityManager->flush();

        return new JsonResponse($category);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws \Exception
     */
    #[Route('/category-hw-delete/{id}', name: 'category_hw_delete')]
    public function delete(string $id): JsonResponse
    {
        $category = $this->entityManager->getRepository(CategoryHW::class)->find($id);

        if (!$category) {
            throw new Exception("Category not found!");
        }
        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return new JsonResponse($category);
    }
}