<?php

namespace App\Controller;

use App\Entity\Element;
use App\Entity\Module;
use App\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

#[Route('/{module}', name: "module")]
class ModuleController extends AbstractController
{


    #[Route('/{type}/', name: "ListElement")]
    public function listElements(
        #[MapEntity(mapping: ['module' => 'name'])] Module $module,
        #[MapEntity(mapping: ['type' => 'name'])] Type $type = null
    ): Response
    {

        if ($type === null) {
            $type = $module->getTypes()->first();
        }

        return $this->render('views/Module/listElements.html.twig', [
            'module' => $module,
            'type' => $type
        ]);
    }

    #[Route('/{type}/{element}', name: "ShowElement")]
    public function showElement(
        #[MapEntity(mapping: ['module' => 'name'])] Module $module,
        #[MapEntity(mapping: ['type' => 'name'])] Type $type,
        string $element
    ): Response
    {

        $elementObject = null;

        foreach ($type->getElements() as $e) {
            if ($e->getName() === $element) {
                $elementObject = $e;
                break;
            }
        }

        if (!$elementObject) {
            foreach ($module->getElements() as $e) {
                if ($e->getName() === $element) {
                    $elementObject = $e;
                    break;
                }
            }

            if (!$elementObject) {
                return $this->redirectToRoute("error404");
            }
        }

        if ($elementObject->getType()->getId() !== $type->getId()) {
            return $this->redirectToRoute("moduleShowElement", [
                "module" => $elementObject->getModule()->getName(),
                "type" => $elementObject->getType()->getName(),
                "element" => $elementObject->getName()
            ]);
        }

        return $this->render('views/Module/showElement.html.twig', [
            'module' => $module,
            'element' => $elementObject
        ]);
    }

    #[Route('/', name: "Changelog")]
    public function changelog(
        #[MapEntity(mapping: ['module' => 'name'])] Module $module
    ): Response
    {

        return $this->render("", [
            "module" => $module
        ]);
    }

}