<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CreateCategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'categories')]
    public function categories(CategoryRepository $categoryRepo): Response
    {
        $categories = $categoryRepo->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/categories/new', name: 'newCategory')]
    public function newCategory(Request $request, ManagerRegistry $manager): Response
    {
        $category = new Category();

        $form = $this->createForm(CreateCategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->getManager()->persist($category);
            $manager->getManager()->flush();

            $this->addFlash("success", "Le produit à bien été ajouté");
            return $this->redirectToRoute('categories');
        }
        
        return $this->render('category/newCategory.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/category/{id}', name: 'app_category')]
    public function category(Category $category): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
}
