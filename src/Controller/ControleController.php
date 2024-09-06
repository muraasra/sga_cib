<?php

namespace App\Controller;

use App\Entity\Controle;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $controle=$doctrine->getRepository(Controle::class)->findBy(['statut_demande' =>true]);

        return $this->render('controle/demandeList.html.twig', [
            'controller_name' => 'ControleController',
            'demandeControles' => $demandeControle,
            'demandesNonControlees' => $demandeControle,
            'demandesControlees' => $controle,
            'active_page' => 'demandeList',
        ]);
    }
    #[Route('/controle/demande/date/{id}', name: 'app_controle.demandeDate')]
    public function demandeDate($id,ManagerRegistry $doctrine,Request $request): Response
    {   
      
        $date = new \DateTime($request->request->get("date_controle"));
       
        $demandeControle=$doctrine->getRepository(Controle::class)->find($id);
        $demandeControle->setDateControle($date);
        $entityManager=$doctrine->getManager();
        $entityManager->persist($demandeControle);
        $entityManager->flush();

        return $this->redirectToRoute('app_controle.demandeList');
    }
}
