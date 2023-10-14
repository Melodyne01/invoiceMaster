<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Entity\ProductInvoice;
use App\Form\CreateInvoiceType;
use App\Repository\InvoiceRepository;
use App\Form\CreateProductInvoiceType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProductInvoiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InvoiceController extends AbstractController
{
    #[Route('/invoices', name: 'invoices')]
    public function index(InvoiceRepository $invoiceRepo): Response
    {
        $invoices = $invoiceRepo->findAll();
        return $this->render('invoice/index.html.twig', [
            'invoices' => $invoices,
        ]);
    }
    #[Route('/invoices/new', name: 'newInvoice')]
    public function newInvoice(Request $request, ManagerRegistry $manager): Response
    {
        $invoice = new Invoice();

        $form = $this->createForm(CreateInvoiceType::class, $invoice);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoice->setPriceHT(0);
            $manager->getManager()->persist($invoice);
            $manager->getManager()->flush();

            $this->addFlash("success", "La facture à bien été ajouté");
            return $this->redirectToRoute('invoices');
        }
        return $this->render('invoice/newInvoice.html.twig', [
            "form" => $form->createView()
        ]);
    }
    
    #[Route('/invoice/{id}', name: 'invoice')]
    public function invoice(Invoice $invoice, Request $request, ManagerRegistry $manager, ProductInvoiceRepository $productInvoiceRepo): Response
    {
        $totalPrice = 0;

        $productInvoice = new ProductInvoice();

        $form = $this->createForm(CreateProductInvoiceType::class, $productInvoice);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $productInvoiceRepo->findAllByInvoice($invoice);
            foreach ($products as $product){
                $totalPrice += ($product->getPriceHT()*$product->getQuantity());
            }
            $invoice->setPriceHT($totalPrice+($productInvoice->getPriceHT()*$productInvoice->getQuantity()));
            $productInvoice->setInvoice($invoice);
            $manager->getManager()->persist($productInvoice);
            $manager->getManager()->persist($invoice);
            $manager->getManager()->flush();

            $this->addFlash("success", "La facture à bien été ajouté");
            return $this->redirectToRoute('invoice',[
                'id' => $invoice->getId()
            ]);
        }

        $products = $productInvoiceRepo->findBy([
            "invoice" => $invoice
        ]);
        return $this->render('invoice/invoice.html.twig', [
            'invoice' => $invoice,
            'products' => $products,
            'form' => $form->createView()
           
        ]);
    }

    #[Route('/invoiceProduct/{id}', name: 'invoiceProduct')]
    public function invoiceProduct(Request $request, ManagerRegistry $manager, ProductInvoice $productInvoice, ProductInvoiceRepository $productInvoiceRepo): Response
    {
        $totalPrice = 0;

        $form = $this->createForm(CreateProductInvoiceType::class, $productInvoice);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $products = $productInvoiceRepo->findAllByInvoice($productInvoice->getInvoice());
            foreach ($products as $product){
                $totalPrice += ($product->getPriceHT()*$product->getQuantity());
            }
            $invoice = $productInvoice->getInvoice();
            $invoice->setPriceHT($totalPrice);
            $manager->getManager()->persist($productInvoice);
            $manager->getManager()->persist($invoice);
            $manager->getManager()->flush();

            $this->addFlash("success", "La facture à bien été ajouté");
            return $this->redirectToRoute('invoice',[
                'id' => $productInvoice->getInvoice()->getId()
            ]);
        }
        return $this->render('invoice/invoiceProduct.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
