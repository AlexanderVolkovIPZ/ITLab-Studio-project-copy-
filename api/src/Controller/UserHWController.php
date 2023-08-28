<?php

namespace App\Controller;

use App\Entity\CategoryHW;
use App\Entity\UserHW;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserHWController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $passwordHasher;

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
     * @param UserPasswordHasherInterface $passwordHasher
     * @param DenormalizerInterface $denormalizer
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, DenormalizerInterface $denormalizer, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->denormalizer = $denormalizer;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/user-hw-create', name: 'user-create', methods: ["POST"])]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['username'], $requestData['password'])) {
            throw new Exception("Invalid request data",);
        }

        $user = $this->denormalizer->denormalize($requestData, UserHW::class, "array");
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            throw new Exception((string)$errors);
        }

        $user->setEmail($requestData['username']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $requestData['password']
        );
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse($user->jsonSerialize(), Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/user-hw-read', name: 'user_hw_read', methods: ["GET"])]
    public function read(Request $request): JsonResponse
    {
        $users = $this->entityManager->getRepository(UserHW::class)->findAll();
        $tmpResponce = null;

        foreach ($users as $user) {
            $tmpResponce[] = $user->jsonSerialize();
        }

        return new JsonResponse($tmpResponce, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/user-hw-get/{id}', name: 'user_hw_get', methods: ["GET"])]
    public function getItem(string $id): JsonResponse
    {
        $user = $this->entityManager->getRepository(UserHW::class)->find($id);

        if (!$user) {
            throw new NotFoundHttpException("Sorry, current user don't exist!");
        }

        return new JsonResponse($user->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/user-hw-update/{id}', name: 'user_hw_update', methods: ["PATCH"])]
    public function update(string $id, Request $request): JsonResponse
    {
        $user = $this->getUser();
        $userUpdate = $this->entityManager->getRepository(UserHW::class)->find($id);

        if ($user !== $userUpdate) {
            throw new AccessDeniedException("Updating error!");
        }

        $requestData = json_decode($request->getContent(), true);

        if (isset($requestData["username"])) {
            $user->setEmail($requestData["username"]);
        }

        if (isset($requestData["password"])) {
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                $requestData['password']
            ));
        }

        $this->entityManager->flush();

        return new JsonResponse($user, Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/user-hw-delete/{id}', name: 'user_hw_delete', methods: ["DELETE"])]
    public function delete(string $id): JsonResponse
    {

        $user = $this->getUser();
        $userDelete = $this->entityManager->getRepository(UserHW::class)->find($id);

        if ($user !== $userDelete) {
            throw new AccessDeniedException("Deleting error!");
        }

        $this->entityManager->remove($userDelete);
        $this->entityManager->flush();

        return new JsonResponse($userDelete, Response::HTTP_NO_CONTENT);
    }
}