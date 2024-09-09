<?php

namespace App\Controller;

use App\Entity\Controle;
use App\Entity\Pv;
use App\Form\ControleType;
use App\Service\MailerService;
use App\Service\UploadsFile;
use Doctrine\ORM\EntityManagerInterface;
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
    /**
     * @Route("/controle/{id}/edit", name="edit_controle")
     */
    #[Route('/controle/edit/{id}', name: 'app_controle.edit')]
    public function edit($id, Request $request, EntityManagerInterface $entityManager,UploadsFile $uploadsFile): Response
    {
        $demandeControle = $entityManager->getRepository(Controle::class)->find($id);
        // $pvControle = $entityManager->getRepository(Pv::class)->find($demandeControle->getCourrierDemande());
        $pvControle = new Pv();
        $pvControle->setCourrierDemande($demandeControle->getCourrierDemande());
        
        $form = $this->createForm(ControleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion du statut
            $statut = $form->get('statut')->getData();
            $demandeControle->setStatut($statut);

            // Si accepté, on traite l'import du PV
            if ($statut === 'accepte') {
                $pvFile = $form->get('pv')->getData();

                if ($pvFile) {
                $directory=$this->getParameter("controle_directory");
                $pvControle->setPathPv($uploadsFile->uploadsFile($pvFile,$directory,$demandeControle->getCourrierDemande()->getExpediteur()));
                  
                }
                
            } else {
                // Si refusé, on supprime le fichier PV (s'il existe)
                $pvControle->setPathPv(null);
            }

            // Enregistrer les modifications dans la base de données
            $entityManager->flush();

            return $this->redirectToRoute('app_controle.demandeList'); // Redirection vers la liste des contrôles
        }

        return $this->render('controle/edit.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }
}
