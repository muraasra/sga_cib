<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use App\Service\UploadsFile;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StagiaireController extends AbstractController
{
    #[Route('/stagiaire', name: 'app_stagiaire')]
    public function index(): Response
    {
        return $this->render('stagiaire/index.html.twig', [
            'controller_name' => 'StagiaireController',
        ]);
    }
    #[Route('/stagiaire/candidature', name: 'app_stagiaire.canditature')]
    public function addCandidature(
            ManagerRegistry $doctrine,
            Request $request ,
            UploadsFile $uploadsFile,
            StagiaireRepository $stagiaireRepository,
    ): Response
    {
        $stagiaire = new Stagiaire();
        $form=$this->createForm(StagiaireType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
        
        // upload du cv
        
    
           
        }


        return $this->render('stagiaire/candidature.html.twig', [
            'form' => $form->createView(),
            'active_page' => 'candidature'
        ]);
    }
}
