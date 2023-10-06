<?php

namespace App\Controller;

use App\Entity\Bedroom;
use App\Entity\Property;
use App\Form\BedroomType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BedroomController extends AbstractController
{
    #[Route('/bedroom/addBedroom/{id}', name: 'app_addBedroom_property')]
    public function addBedroom(Request $request, EntityManagerInterface $entityManager, Property $property)
    {

        $bedroom = new Bedroom();
        $form = $this->createForm(BedroomType::class, $bedroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $bedroom->setM2($bedroom->getM2());
            $bedroom->setName($bedroom->getName());
            $bedroom->setPrice($bedroom->getPrice());
            $bedroom->setNumberOfRoom($bedroom->getNumberOfRoom());

            $bedroom->setPropertyId($property);

            $images = $form->getData()->getImage();
            foreach ($images as $image) {
                $image->setBedroom($bedroom);
            }

            $entityManager->persist($bedroom);
            $entityManager->flush();

            return $this->redirectToRoute('app_show_property', ['id'=>$property->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bedroom/addBedroom.html.twig', [
            'property'=>$property,
            'bedroom'=>$bedroom,
            'form'=>$form,
        ]);
    }

    #[Route('/bedroom/showBedroom/{id}', name: 'app_showBedroom_property')]
    public function showBedroom(Bedroom $bedroom)
    {
        return $this->render('bedroom/showBedroom.html.twig', [
            'bedroom'=>$bedroom,
        ]);
    }

    #[Route('/bedroom/delete/bedroom/{id}', name: 'app_delete_property_bedroom')]
    public function deleteBedroom(EntityManagerInterface $entityManager, Bedroom $bedroom): Response
    {
        $entityManager->remove($bedroom);
        $entityManager->flush();

        return $this->redirectToRoute('app_show_property', ['id'=>$bedroom->getPropertyId()->getId()], Response::HTTP_SEE_OTHER);
    }
}
