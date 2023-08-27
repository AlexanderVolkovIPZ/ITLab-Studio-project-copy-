<?php

namespace App\Controller;

use App\Entity\CategoryHW;
use App\Entity\OrderHW;
use App\Entity\ProductHW;
use App\Entity\UserHW;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class OrderHWController extends AbstractController
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
    #[Route('/order-hw-create', name: 'order_hw_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (!in_array(UserHW::ROLE_USER, $user->getRoles())) {
            throw new AccessDeniedException("Access denied! You are not just a user!");
        }

        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['user'], $requestData['dateOrder']) || $requestData['user'] != $user->getId()) {
            throw new Exception("Invalid request data!");
        }

        $userOrder = $this->entityManager->getRepository(UserHW::class)->find($requestData['user']);

        if (!$userOrder) {
            throw new Exception("Invalid request data!");
        }

        $order = new OrderHW();
        $order->setUser($userOrder)->setDateOrder(new DateTime($requestData['dateOrder']));

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return new JsonResponse($order->jsonSerialize(), Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/order-hw-read', name: 'order_hw_read', methods: ['GET'])]
    public function read(Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (in_array(UserHW::ROLE_ADMIN, $user->getRoles())) {
            $orders = $this->entityManager->getRepository(OrderHW::class)->findAll();
        } elseif (in_array(UserHW::ROLE_USER, $user->getRoles())) {
            $orders = $this->entityManager->getRepository(OrderHW::class)->findBy([
                "user" => $user
            ]);
        } else {
            throw new AccessDeniedException("Access denied!");
        }

        $tmpResponce = null;

        foreach ($orders as $order) {
            $tmpResponce[] = $order->jsonSerialize();
        }

        return new JsonResponse($tmpResponce, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/order-hw-get/{id}', name: 'order_hw_get_item', methods: ['GET'])]
    public function getItem(string $id): JsonResponse
    {
        $user = $this->getUser();

        if (in_array(UserHW::ROLE_ADMIN, $user->getRoles())) {
            $order = $this->entityManager->getRepository(OrderHW::class)->find($id);
        } elseif (in_array(UserHW::ROLE_USER, $user->getRoles())) {
            $order = $this->entityManager->getRepository(OrderHW::class)->findBy([
                'id' => $id,
                'user' => $user
            ]);
        } else {
            throw new AccessDeniedException("Access denied!");
        }

        if (!$order) {
            throw new NotFoundHttpException("Order with id = {$id} is not found!");
        }

        return new JsonResponse($order, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/order-hw-update/{id}', name: 'order_hw_update', methods: ['PATCH'])]
    public function update(string $id, Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (!in_array(UserHW::ROLE_USER, $user->getRoles())) {
            throw new AccessDeniedException("Access denied!");
        }
        $order = $this->entityManager->getRepository(OrderHW::class)->findOneBy([
            "id" => $id,
            "user" => $user
        ]);

        if (!$order) {
            throw new NotFoundHttpException("Order with id = {$id} is not found!");
        }

        $requestData = json_decode($request->getContent(), true);

        if (isset($requestData['dateOrder'])) {
            $order->setDateOrder(new DateTime($requestData['dateOrder']));
        }

        $this->entityManager->flush();

        return new JsonResponse($order, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/order-hw-delete/{id}', name: 'order_hw_delete', methods: ['DELETE'])]
    public function delete(string $id): JsonResponse
    {
        $user = $this->getUser();

        if (!in_array(UserHW::ROLE_USER, $user->getRoles())) {
            throw new AccessDeniedException("Access denied!");
        }
        $order = $this->entityManager->getRepository(OrderHW::class)->findOneBy([
            "id" => $id,
            "user" => $user
        ]);

        if (!$order) {
            throw new NotFoundHttpException("Order with id = {$id} is not found!");
        }

        $this->entityManager->remove($order);
        $this->entityManager->flush();

        return new JsonResponse($order, Response::HTTP_NO_CONTENT);
    }
}