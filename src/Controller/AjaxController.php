<?php

namespace App\Controller;

use App\Entity\Element;
use App\Entity\Module;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('internal/api/{target}', name: "api")]
class AjaxController extends AbstractController
{

    #[Route('/{element}/description', name: "Description")]
    public function description(
        Request $request,
        Element $element,
        string $target
    ) {

        if ($request->getMethod() === "GET") {
            return new Response($element->getDescription(), 200, ["content-type" => "text/plain"]);
        }
    }

}