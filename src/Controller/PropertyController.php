<?php

namespace App\Controller;

use App\Entity\Bedroom;
use App\Entity\Info;
use App\Entity\Property;
use App\Entity\Situation;
use App\Form\BedroomType;
use App\Form\InfoType;
use App\Form\PropertyType;
use App\Form\SituationType;
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

            return $this->redirectToRoute('app_property_addSituation', ['id'=>$property->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('property/new.html.twig', [
            'property'=>$property,
            'form'=>$form,
        ]);
    }

    #[Route('/property/addSituation/{id}', name: 'app_property_addSituation')]
    public function addSituation(Request $request, EntityManagerInterface $entityManager, Property $property): Response
    {

        $situation = new Situation();

        $form = $this->createForm(SituationType::class, $situation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $situation->setCountry($situation->getCountry());
            $situation->setCity($situation->getCity());
            $situation->setZipCode($situation->getZipCode());
            $situation->setAddress($situation->getAddress());

            $situation->setPropertyId($property);

            $entityManager->persist($situation);
            $entityManager->flush();

            return $this->redirectToRoute('app_property_addInfo', ['id'=>$property->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('property/addSituation.html.twig', [
            'situation'=>$situation,
            'form'=>$form,
        ]);
    }

    #[Route('/property/addInfos/{id}', name: 'app_property_addInfo')]
    public function addInfos(Request $request, EntityManagerInterface $entityManager, Property $property): Response
    {

        $info = new Info();

        $form = $this->createForm(InfoType::class, $info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $info->setUrlProperty($info->getUrlProperty());

            $images = $form->getData()->getImage();
            foreach ($images as $image) {
                $image->setInfo($info);
            }

            $info->setPropertyId($property);

            $entityManager->persist($info);
            $entityManager->flush();

            return $this->redirectToRoute('app_property', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('property/addInfo.html.twig', [
            'info'=>$info,
            'form'=>$form,
        ]);
    }



    #[Route('/property/{id}/show', name: 'app_show_property')]
    public function show(Property $property)
    {
        return $this->render('property/show.html.twig', [
            'property'=>$property
        ]);
    }



    #[Route('/property/addBedroom/{id}', name: 'app_addBedroom_property')]
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

        return $this->render('property/addBedroom.html.twig', [
            'property'=>$property,
            'bedroom'=>$bedroom,
            'form'=>$form,
        ]);
    }

    #[Route('/property/showBedroom/{id}', name: 'app_showBedroom_property')]
    public function showBedroom(Bedroom $bedroom)
    {
        return $this->render('property/showBedroom.html.twig', [
            'bedroom'=>$bedroom,
        ]);
    }

    #[Route('/property/delete/bedroom/{id}', name: 'app_delete_property_bedroom')]
    public function deleteBedroom(EntityManagerInterface $entityManager, Bedroom $bedroom): Response
    {
        $entityManager->remove($bedroom);
        $entityManager->flush();

        return $this->redirectToRoute('app_show_property', ['id'=>$bedroom->getPropertyId()->getId()], Response::HTTP_SEE_OTHER);
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
