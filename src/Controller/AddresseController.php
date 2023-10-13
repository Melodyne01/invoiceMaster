<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddresseController extends AbstractController
{
    #[Route('/addresses', name: 'addresses')]
    public function addresses(): Response
    {
        return $this->render('addresse/index.html.twig', [
            'controller_name' => 'AddresseController',
        ]);
    }
}
