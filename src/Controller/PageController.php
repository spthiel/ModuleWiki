<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{

    #[Route('/', name: "list")]
    public function list(): Response
    {
        return $this->render('templates/Page/list.html.twig');
    }

    #[Route('/404', name: "error404")]
    public function error404(): Response
    {
        return $this->render('templates/Page/404.html.twig');
    }

}