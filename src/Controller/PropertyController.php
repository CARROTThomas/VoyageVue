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



    // Name + Description + établissement
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
    #[Route('/property/edit/{id}', name: 'app_property_edit')]
    public function editProperty(Request $request, EntityManagerInterface $entityManager, Property $property): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('property/edit.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }


    // Situation
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
    #[Route('/property/editSituation/{id}', name: 'app_property_editSituation')]
    public function editSituation(Request $request, EntityManagerInterface $entityManager, Situation $situation): Response
    {
        $form = $this->createForm(SituationType::class, $situation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('property/editSituation.html.twig', [
            'situation' => $situation,
            'form' => $form,
        ]);
    }


    // Url + image
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
    #[Route('/property/editInfos/{id}', name: 'app_property_editInfos')]
    public function editInfos(Request $request, EntityManagerInterface $entityManager, Info $info): Response
    {
        $form = $this->createForm(InfoType::class, $info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('property/editInfos.html.twig', [
            'info' => $info,
            'form' => $form,
        ]);
    }


    // Show Propriété
    #[Route('/property/{id}/show', name: 'app_show_property')]
    public function show(Property $property)
    {
        return $this->render('property/show.html.twig', [
            'property'=>$property
        ]);
    }

    // delete un objet
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
