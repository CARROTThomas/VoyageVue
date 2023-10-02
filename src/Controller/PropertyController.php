<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\PropertyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    #[Route('/property', name: 'app_property')]
    public function index(): Response
    {
        if (!$this->getUser()) {return $this->redirectToRoute('app_login');}

        return $this->render('property/index.html.twig', [
            'properties'=>$this->getUser()->getProperties(),
        ]);
    }

    #[Route('/property/new', name: 'app_new_property')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $property->setName($property->getName());
            $property->setDescription($property->getDescription());

            $property->setOwner($this->getUser());


            $entityManager->persist($property);
            $entityManager->flush();

            return $this->redirectToRoute('app_new_property_addInfo', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('property/new.html.twig', [
            'property'=>$property,
            'form'=>$form,
        ]);
    }

    #[Route('/property/addInfo', name: 'app_new_property_addInfo')]
    public function newInfo(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->render('property/addInfo.html.twig', [

        ]);
    }




    #[Route('/property/{id}/edit', name: 'app_show_property')]
    public function show(Property $property)
    {
        return $this->render('property/show.html.twig', [
            'property'=>$property
        ]);
    }


    #[Route('/property/delete/{id}', name: 'app_delete_property', methods: ['POST'])]
    public function delete(Request $request, Property $property, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->request->get('_token'))) {
            $entityManager->remove($property);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_property', [], Response::HTTP_SEE_OTHER);
    }
}
