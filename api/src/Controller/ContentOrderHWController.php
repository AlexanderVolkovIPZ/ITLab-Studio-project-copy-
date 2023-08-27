<?php

namespace App\Controller;

use App\Entity\CategoryHW;
use App\Entity\ContentOrderHW;
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

class ContentOrderHWController extends AbstractController
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
    #[Route('/content-order-hw-create', name: 'content_order_hw_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (!in_array(UserHW::ROLE_USER, $user->getRoles())) {
            throw new AccessDeniedException("Access denied! You are not just a user!");
        }

        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['product'], $requestData['order'], $requestData['count'])) {
            throw new Exception("Invalid request data!");
        }

        $product = $this->entityManager->getRepository(ProductHW::class)->find($requestData['product']);
        $order = $this->entityManager->getRepository(OrderHW::class)->findBy(
            [
                'id' => $requestData['order'],
                'user' => $user
            ]
        )[0];

        if (empty($product) || empty($order)) {
            throw new Exception("Invalid request data!");
        }

        $contentOrder = new ContentOrderHW();
        $contentOrder->setOrder($order)->setProduct($product)->setCount($requestData['count']);

        $this->entityManager->persist($contentOrder);
        $this->entityManager->flush();

        return new JsonResponse($order->jsonSerialize(), Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/content-order-hw-read', name: 'content_order_hw_read', methods: ['GET'])]
    public function read(Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (in_array(UserHW::ROLE_ADMIN, $user->getRoles())) {

            $contentOrder = $this->entityManager->getRepository(ContentOrderHW::class)->findAll();

        } elseif (in_array(UserHW::ROLE_USER, $user->getRoles())) {

            $orders = $this->entityManager->getRepository(OrderHW::class)->findBy([
                'user' => $user
            ]);

            $contentOrder = [];
            foreach ($orders as $order) {
                $contentOrder[] = $this->entityManager->getRepository(ContentOrderHW::class)->find($order->getId());
            }

        } else {
            throw new AccessDeniedException("Access denied!");
        }

        return new JsonResponse($contentOrder, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/content-order-hw-get/{id}', name: 'content_order_hw_get_item', methods: ['GET'])]
    public function getItem(string $id): JsonResponse
    {
        $user = $this->getUser();

        if (in_array(UserHW::ROLE_ADMIN, $user->getRoles())) {

            $contentOrder = $this->entityManager->getRepository(ContentOrderHW::class)->find($id);

        } elseif (in_array(UserHW::ROLE_USER, $user->getRoles())) {

            $contentOrder = $this->selectUserContentOrderById($user, $id);

        } else {

            throw new AccessDeniedException("Access denied!");

        }

        if (!$contentOrder) {
            throw new NotFoundHttpException("ContentOrder with id = {$id} is not found!");
        }

        return new JsonResponse($contentOrder[0], Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/content-order-hw-update/{id}', name: 'content_order_hw_update', methods: ['PATCH'])]
    public function update(string $id, Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (!in_array(UserHW::ROLE_USER, $user->getRoles())) {
            throw new AccessDeniedException("Access denied!");
        }

        $contentOrder = $this->selectUserContentOrderById($user, $id);

        if (empty($contentOrder)) {
            throw new NotFoundHttpException("ContentOrder with id = {$id} is not found!");
        }
        $contentOrder = $this->entityManager->getRepository(ContentOrderHW::class)->find($id);

        $requestData = json_decode($request->getContent(), true);

        if (isset($requestData['count'])) {
            $contentOrder->setCount($requestData['count']);
        }

        if (isset($requestData['product'])) {
            $product = $this->entityManager->getRepository(ProductHW::class)->find($requestData['product']);
            isset($product) ? $contentOrder->setProduct($product) : throw new Exception("Invalid request data!");
        }

        if (isset($requestData['order'])) {
            $order = $this->entityManager->getRepository(OrderHW::class)->find($requestData['order']);
            isset($order) ? $contentOrder->setProduct($order) : throw new Exception("Invalid request data!");
        }

        $this->entityManager->flush();

        return new JsonResponse($contentOrder, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/content-order-hw-delete/{id}', name: 'content_order_hw_delete', methods: ['DELETE'])]
    public function delete(string $id): JsonResponse
    {
        $user = $this->getUser();

        if (!in_array(UserHW::ROLE_USER, $user->getRoles())) {
            throw new AccessDeniedException("Access denied!");
        }

        $contentOrder = $this->selectUserContentOrderById($user, $id);

        if (empty($contentOrder)) {
            throw new NotFoundHttpException("ContentOrder with id = {$id} is not found!");
        }

        $contentOrder = $this->entityManager->getRepository(ContentOrderHW::class)->find($id);

        $this->entityManager->remove($contentOrder);
        $this->entityManager->flush();

        return new JsonResponse($contentOrder, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $user
     * @param $id
     * @return float|int|mixed|string
     */
    public function selectUserContentOrderById($user, $id)
    {
        return $this->entityManager->createQueryBuilder()
            ->select('o')
            ->from(OrderHW::class, 'o')
            ->innerJoin('o.user', 'u')
            ->innerJoin('o.contentOrder', 'co')
            ->where('co.id = :id')
            ->andWhere('o.user = :user')
            ->setParameter("id", $id)
            ->setParameter("user", $user)
            ->getQuery()
            ->getResult();
    }
}