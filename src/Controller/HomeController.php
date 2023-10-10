<?php

namespace App\Controller;

use App\Repository\InfoRepository;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    #[Route('/search', name: 'app_home_search')]
    public function index(Request $request, PropertyRepository $propertyRepository): Response
    {
        $routeName = $request->attributes->get("_route");

        if($routeName ==="app_home_search"){

            $value = $request->get('search');
            $result = $propertyRepository->findByExampleField($value);

            if (!$value) {
                return $this->redirectToRoute('app_home');
            }

            return $this->render('home/index.html.twig', [
                "properties"=>$result,
            ]);
        }


        return $this->render('home/index.html.twig', [
            "properties"=>$propertyRepository->findAll()
        ]);
    }
}
