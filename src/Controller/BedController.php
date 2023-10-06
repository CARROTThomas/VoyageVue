<?php

namespace App\Controller;

use App\Entity\Bed;
use App\Entity\Bedroom;
use App\Form\BedType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BedController extends AbstractController
{
    #[Route('/bed', name: 'app_bed')]
    public function index(): Response
    {
        return $this->render('bed/index.html.twig', []);
    }

    #[Route('/bed/new/{id}', name: 'app_bed_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, Bedroom $bedroom): Response
    {
        $bed = new Bed();
        $form = $this->createForm(BedType::class, $bed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $bed->setBedroomId($bedroom);

            $entityManager->persist($bed);
            $entityManager->flush();

            return $this->redirectToRoute('app_showBedroom_property', ['id'=>$bedroom->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bed/new.html.twig', [
            'bed' => $bed,
            'form' => $form,
            'bedroom'=>$bedroom,
        ]);
    }

    #[Route('/bed/edit/{id}', name: 'app_bed_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, Bed $bed): Response
    {

        $form = $this->createForm(BedType::class, $bed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_showBedroom_property', ['id'=>$bed->getBedroomId()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bed/edit.html.twig', [
            'bed' => $bed,
            'form' => $form,
        ]);
    }








    #[Route('/bed/delete/{id}', name: 'app_bed_delete')]
    public function delete(EntityManagerInterface $entityManager, Bed $bed): Response
    {
        $entityManager->remove($bed);
        $entityManager->flush();

        return $this->redirectToRoute('app_showBedroom_property', ['id'=>$bed->getBedroomId()->getId()], Response::HTTP_SEE_OTHER);
    }
}
