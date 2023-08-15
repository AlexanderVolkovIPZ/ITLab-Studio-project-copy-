<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(Request $request): JsonResponse
    {
        //Для POST
        dd($request->query->all());


        //Повернення JSON рядком
//        $var = json_decode($request->getContent(),true);



        //Для GET
        dd($request->request->all());
        $test = ['test'=>1];

        return new JsonResponse($test);
//        return json_encode($test);
    }

//    #[Route('/tmp', name: 'app_test')]
//    public function tmp(): JsonResponse
//    {
//        return $this->json([
//            'message' => 'Welcome to your tmp controller!',
//            'path' => 'src/Controller/TestController.php',
//        ]);
//    }
}
