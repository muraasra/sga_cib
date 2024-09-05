<?php

namespace App\Controller;

use App\Entity\Controle;
use Doctrine\Persistence\ManagerRegistry;
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
    #[Route('/controle/demande/list', name: 'app_controle.demandeList')]
    public function demandeList(ManagerRegistry $doctrine): Response
    {
        $demandeControle=$doctrine->getRepository(Controle::class)->findBy(['statut_demande' =>false]);

        return $this->render('controle/demandeList.html.twig', [
            'controller_name' => 'ControleController',
            'demandeControles' => $demandeControle,
            'active_page' => 'demandeList',
        ]);
    }
}
