<?php

namespace App\Controller;

use App\Entity\CategoryHW;
use App\Entity\OrderHW;
use App\Entity\ProducerHW;
use App\Entity\ProductHW;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    #[Route('/order-hw-create', name: 'order_hw_create')]
    public function create(Request $request): JsonResponse
    {
        $user = $this->getUser();
        if (in_array(User::ROLE_USER, $user->getRoles())) {
            $requestData = json_decode($request->getContent(), true);

            if (!isset($requestData['user'], $requestData['product'], $requestData['count'], $requestData['dateOrder'])) {
                throw new Exception("Invalid request data!");
            }
            $productOrder = $this->entityManager->getRepository(ProductHW::class)->find($requestData['product']);

            if (!$productOrder) {
                throw new Exception("Product with id " . $requestData['product'] . " not found");
            }

            $userOrder = $this->entityManager->getRepository(User::class)->find($requestData['user']);

            if (!$userOrder) {
                throw new Exception("Customer with id " . $requestData['user'] . " not found");
            }

            $order = new OrderHW();

            $order->setProduct($productOrder)
                ->setUser($userOrder)
                ->setCount($requestData['count'])
                ->setDateOrder(new DateTime($requestData['dateOrder']));

            $this->entityManager->persist($order);
            $this->entityManager->flush();

            return new JsonResponse($order->jsonSerialize(), Response::HTTP_CREATED);
        } else {
            return new JsonResponse("Access denied! You are not just a user!");
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/order-hw-read', name: 'order_hw_read')]
    public function read(Request $request): JsonResponse
    {
        $orders = $this->entityManager->getRepository(OrderHW::class)->findAll();
        $tmpResponce = null;

        foreach ($orders as $order) {
            $tmpResponce[] = $order->jsonSerialize();
        }

        return new JsonResponse($tmpResponce);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/order-hw/{id}', name: 'order_hw_get_item')]
    public function getItem(string $id): JsonResponse
    {
        $order = $this->entityManager->getRepository(OrderHW::class)->find($id);

        if (!$order) {
            throw new Exception("Order not found!");
        }

        return new JsonResponse($order->jsonSerialize());
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/order-hw-update/{id}', name: 'order_hw_update')]
    public function update(string $id): JsonResponse
    {
        $user = $this->getUser();

        if (in_array(User::ROLE_USER, $user->getRoles())) {
            $order = $this->entityManager->getRepository(OrderHW::class)->findOneBy([
                "id" => $id,
                "user" => $user
            ]);

            if (!$order) {
                throw new Exception("Order not found!");
            }

            $order->setCount(11);
            $this->entityManager->flush();

            return new JsonResponse($order);
        } else {
            return new JsonResponse("Access denied!");
        }
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/order-hw-delete/{id}', name: 'order_hw_delete')]
    public function delete(string $id): JsonResponse
    {
        $user = $this->getUser();

        if (in_array(User::ROLE_USER, $user->getRoles())) {
            $order = $this->entityManager->getRepository(OrderHW::class)->findOneBy([
                "id" => $id,
                "user" => $user
            ]);

            if (!$order) {
                throw new Exception("Order not found!");
            }

            $this->entityManager->remove($order);
            $this->entityManager->flush();

            return new JsonResponse($order);
        } else {
            return new JsonResponse("Access denied!");
        }
    }
}