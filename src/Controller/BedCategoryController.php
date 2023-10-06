<?php

namespace App\Controller;

use App\Entity\BedCategory;
use App\Form\BedCategoryType;
use App\Repository\BedCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bed/category')]
class BedCategoryController extends AbstractController
{
    #[Route('/', name: 'app_bed_category_index', methods: ['GET'])]
    public function index(BedCategoryRepository $bedCategoryRepository): Response
    {
        return $this->render('bed_category/index.html.twig', [
            'bed_categories' => $bedCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bed_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bedCategory = new BedCategory();
        $form = $this->createForm(BedCategoryType::class, $bedCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bedCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_bed_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bed_category/new.html.twig', [
            'bed_category' => $bedCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bed_category_show', methods: ['GET'])]
    public function show(BedCategory $bedCategory): Response
    {
        return $this->render('bed_category/show.html.twig', [
            'bed_category' => $bedCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bed_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BedCategory $bedCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BedCategoryType::class, $bedCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bed_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bed_category/edit.html.twig', [
            'bed_category' => $bedCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bed_category_delete', methods: ['POST'])]
    public function delete(Request $request, BedCategory $bedCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bedCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bedCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bed_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
