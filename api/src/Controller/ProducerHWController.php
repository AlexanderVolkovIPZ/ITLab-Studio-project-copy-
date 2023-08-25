<?php

namespace App\Controller;

use App\Entity\CategoryHW;
use App\Entity\ProducerHW;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProducerHWController extends AbstractController
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
    #[Route('/producer-hw-create', name: 'producer_hw_create')]
    public function create(Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (in_array(User::ROLE_ADMIN, $user->getRoles())) {
            $requestData = json_decode($request->getContent(), true);

            if (!isset($requestData['name'], $requestData['description'])) {
                throw new Exception("Invalid request data");
            }

            $producer = new ProducerHW();
            $producer->setName($requestData['name'])
                ->setDescription($requestData['description']);
            $this->entityManager->persist($producer);
            $this->entityManager->flush();

            return new JsonResponse($producer->jsonSerialize(), Response::HTTP_CREATED);
        } else {
            return new JsonResponse("Access denied!");
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/producer-hw-read', name: 'producer_hw_read')]
    public function read(Request $request): JsonResponse
    {
        $producers = $this->entityManager->getRepository(ProducerHW::class)->findAll();
        $tmpResponce = null;

        foreach ($producers as $producer) {
            $tmpResponce[] = $producer->jsonSerialize();
        }

        return new JsonResponse($tmpResponce);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/producer-hw/{id}', name: 'producer_hw_get_item')]
    public function getItem(string $id): JsonResponse
    {
        $producer = $this->entityManager->getRepository(ProducerHW::class)->find($id);

        if (!$producer) {
            throw new Exception("Producer not find!");
        }

        return new JsonResponse($producer->jsonSerialize());
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/producer-hw-update/{id}', name: 'producer_hw_update')]
    public function update(string $id): JsonResponse
    {
        $user = $this->getUser();
        if (in_array(User::ROLE_ADMIN, $user->getRoles())) {
            $producer = $this->entityManager->getRepository(ProducerHW::class)->find($id);

            if (!$producer) {
                throw new Exception("Producer not find!");
            }

            $producer->setName("Apple")->setDescription("Some Description");
            $this->entityManager->flush();

            return new JsonResponse($producer);

        } else {
            return new JsonResponse("Access denied!");
        }
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/producer-hw-delete/{id}', name: 'producer_hw_delete')]
    public function delete(string $id): JsonResponse
    {
        $user = $this->getUser();
        if (in_array(User::ROLE_ADMIN, $user->getRoles())) {
            $producer = $this->entityManager->getRepository(ProducerHW::class)->find($id);

            if (!$producer) {
                throw new Exception("Producer not found!");
            }
            $this->entityManager->remove($producer);
            $this->entityManager->flush();

            return new JsonResponse($producer);
        } else {
            return new JsonResponse("Access denied!");
        }
    }
}