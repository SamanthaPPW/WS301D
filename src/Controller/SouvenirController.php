<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SouvenirController extends AbstractController
{
    #[Route('/souvenir', name: 'app_souvenir')]
    public function index(): Response
    {
        return $this->render('souvenir/index.html.twig', [
            'controller_name' => 'SouvenirController',
        ]);
    }
}
