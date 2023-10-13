<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Supplier;
use App\Form\CreateAddressType;
use App\Form\CreateSupplierType;
use App\Repository\SupplierRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SupplierController extends AbstractController
{
    #[Route('/suppliers', name: 'suppliers')]
    public function suppliers(SupplierRepository $supplierRepo): Response
    {
        $suppliers = $supplierRepo->findAll();
        return $this->render('supplier/index.html.twig', [
            'suppliers' => $suppliers,
        ]);
    }

    #[Route('/suppliers/new', name: 'newSupplier')]
    public function newSuppliers(Request $request, ManagerRegistry $manager): Response
    {
        $supplier = new Supplier();

        $form = $this->createForm(CreateSupplierType::class, $supplier);

        $form->handleRequest($request);

        $address = new Address();

        $addressForm = $this->createForm(CreateAddressType::class, $address);

        $addressForm->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $supplier->setAddress($address);
            $manager->getManager()->persist($address);
            $manager->getManager()->persist($supplier);
            $manager->getManager()->flush();

            $this->addFlash("success", "Le produit à bien été ajouté");
            return $this->redirectToRoute('suppliers');
        }
        
        if ($addressForm->isSubmitted() && $addressForm->isValid()) {
            var_dump($address, $supplier);
            $manager->getManager()->persist($supplier);
            $manager->getManager()->flush();

            $this->addFlash("success", "Le produit à bien été ajouté");
            return $this->redirectToRoute('suppliers');
        }
        return $this->render('supplier/newSupplier.html.twig', [
            "form" => $form->createView(),
            "addressForm" => $addressForm->createView()
        ]);
    }
}
