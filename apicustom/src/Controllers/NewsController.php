<?php

namespace App\Controllers;

use App\Core\Attributes\Route;
use App\Core\Response;


class NewsController
{
    public function  list(): Response
    {
        return new Response("list", "text");
    }

    #[Route("addition")]
    public function add(): Response
    {
        return new Response("list", "text");
    }

    #[Route("home")]
    public function index(): Response
    {
        return new Response("list", "text");
    }
}