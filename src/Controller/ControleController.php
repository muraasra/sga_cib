<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControleController extends AbstractController
{
    #[Route('/controle', name: 'app_controle')]
    public function index(): Response
    {
        return $this->render('controle/index.html.twig', [
            'controller_name' => 'ControleController',
        ]);
    }
}
