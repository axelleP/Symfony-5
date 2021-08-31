<?php

namespace App\Controller;

//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;//pour utiliser les routes
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;//pour utiliser render

class ArticleController extends AbstractController {

    /**
      * @Route("/")
      * @Route("/article/liste")
      */
    public function index()
    {
        return $this->render('article/list.html.twig', [
            'number' => 1,
        ]);
    }
}
