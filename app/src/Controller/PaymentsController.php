<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentsController extends AbstractController
{
    #[Route('/payments', name: 'app_payments')]
    public function index(): Response
    {
        return $this->render('payments/index.html.twig', [
            'controller_name' => 'PaymentsController',
        ]);
    }
}
