<?php

namespace App\Controller;

use DateTime;
use App\Entity\Product;
use App\Form\CreateProductType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'products')]
    public function products(ProductRepository $productRepo): Response
    {
        $products = $productRepo->findAllByNameASC();
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/products/new', name: 'newProduct')]
    public function newProducts(Request $request, ManagerRegistry $manager): Response
    {
        $product = new Product();

        $form = $this->createForm(CreateProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->getManager()->persist($product);
            $manager->getManager()->flush();

            $this->addFlash("success", "Le produit à bien été ajouté");
            return $this->redirectToRoute('products');
        }

        return $this->render('product/newProduct.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
