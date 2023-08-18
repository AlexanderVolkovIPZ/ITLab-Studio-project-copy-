<?php

namespace App\Controller;

use App\Entity\CategoryHW;
use App\Entity\CustomerHW;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerHWController extends AbstractController
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
     * @throws \Exception
     */
    #[Route('/customer-hw-create', name: 'customer_hw_create')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['firstName'], $requestData['middleName'], $requestData['lastName'], $requestData['mobile'], $requestData['email'], $requestData['city'], $requestData['address'])) {
            throw new \Exception("Invalid request data");
        }

        $customer = new CustomerHW();
        $customer->setFirstName($requestData['firstName'])
            ->setMiddleName($requestData['middleName'])
            ->setLastName($requestData['lastName'])
            ->setMobile($requestData['mobile'])
            ->setEmail($requestData['email'])
            ->setCity($requestData['city'])
            ->setAddress($requestData['address']);
        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return new JsonResponse($customer, Response::HTTP_CREATED);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/customer-hw-read', name: 'customer_hw_read')]
    public function read(Request $request): JsonResponse
    {
        $customers = $this->entityManager->getRepository(CustomerHW::class)->findAll();
        $tmpResponce = null;

        foreach ($customers as $customer) {
            $tmpResponce[] = [
                "id" => $customer->getId(),
                "firstName" => $customer->getFirstName(),
                "middleName" => $customer->getMiddleName(),
                "lastName" => $customer->getLastName(),
                "mobile" => $customer->getMobile(),
                "email" => $customer->getEmail(),
                "city" => $customer->getCity(),
                "address" => $customer->getAddress()
            ];
        }

        return new JsonResponse($tmpResponce);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws \Exception
     */
    #[Route('/customer-hw/{id}', name: 'customer_hw_get_item')]
    public function getItem(string $id): JsonResponse
    {
        $category = $this->entityManager->getRepository(CustomerHW::class)->find($id);

        if (!$category) {
            throw new \Exception("Customer not find!");
        }

        return new JsonResponse($category);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws \Exception
     */
    #[Route('/customer-hw-update/{id}', name: 'customer_hw_update')]
    public function update(string $id): JsonResponse
    {
        $customer = $this->entityManager->getRepository(CustomerHW::class)->find($id);

        if (!$customer) {
            throw new Exception("Customer not find!");
        }

        $customer->setFirstName("test_name")
            ->setMiddleName("test_middle_name")
            ->setLastName("test_last_name")
            ->setMobile("test_mobile")
            ->setEmail("test_email")
            ->setCity("test_city")
            ->setAddress("test_address");
        $this->entityManager->flush();

        return new JsonResponse($customer);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/customer-hw-delete/{id}', name: 'customer_hw_delete')]
    public function delete(string $id): JsonResponse
    {
        $customer = $this->entityManager->getRepository(CustomerHW::class)->find($id);

        if (!$customer) {
            throw new Exception("Category not found!");
        }
        $this->entityManager->remove($customer);
        $this->entityManager->flush();

        return new JsonResponse($customer);
    }
}