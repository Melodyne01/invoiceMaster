<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductInvoiceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StockController extends AbstractController
{
    #[Route('/stock', name: 'stock')]
    public function index(ProductInvoiceRepository $productInvoiceRepo): Response
    {
        $products = $productInvoiceRepo->findAllOccurrencesByProduct();
        return $this->render('stock/index.html.twig', [
            'products' => $products
        ]);
    }
    #[Route('/stock/{product}', name: 'stockProduct')]
    public function stockProduct(Product $product, ProductInvoiceRepository $productInvoiceRepo): Response
    {
        $productStock = $productInvoiceRepo->findAllByProduct($product);
        return $this->render('stock/stockProduct.html.twig', [
            'product' => $product,
            'productStock' => $productStock
        ]);
    }
    #[Route('/stock/{product}/{color}', name: 'stockProductColor')]
    public function stockProductColor(Product $product, string $color, ProductInvoiceRepository $productInvoiceRepo): Response
    {

        $productStock = $productInvoiceRepo->findAllByProductAndColor($product, $color);
        return $this->render('stock/stockProductColor.html.twig', [
            'product' => $product,
            'productStock' => $productStock,
            'color' => $color
        ]);
    }
}
