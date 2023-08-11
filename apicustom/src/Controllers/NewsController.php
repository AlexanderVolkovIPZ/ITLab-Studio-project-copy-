<?php

namespace App\Controllers;

use App\Core\Attributes\Route;
use App\Core\Controller;
use App\Core\Response;


class NewsController extends Controller
{
    public function  list(): ?string
    {
        return $this->render([
            'title'=>'title',
            'text'=>'text'
        ]);
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
    public function render(array $assoc_array): string
    {
        $assoc_array['module'] = 'news';
        return parent::render($assoc_array);
    }


}