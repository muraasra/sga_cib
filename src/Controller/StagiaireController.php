<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Entity\User;
use App\Form\HistoriqueType;
use App\Form\StagiaireSecType;
use App\Form\StagiaireType;
use App\Form\TuteurFormType;
use App\Repository\StagiaireRepository;
use App\Service\Helpers;
use App\Service\UploadsFile;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Symfony\Component\Routing\Annotation\Route;

class StagiaireController extends AbstractController
{

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
        
    }
    #[Route('/stagiaire', name: 'app_stagiaire')]
    public function index(): Response
    {
        return $this->render('stagiaire/index.html.twig', [
            'controller_name' => 'StagiaireController',
        ]);
    }
    #[Route('/stagiaire/candidatureSec', name: 'app_stagiaire.canditatureSec')]
    public function addCandidatureSec(
            ManagerRegistry $doctrine,
            Request $request ,
            UploadsFile $uploadsFile,
            StagiaireRepository $stagiaireRepository,
    ): Response
    {
        $stagiaire = new Stagiaire();
        $form=$this->createForm(StagiaireSecType::class, $stagiaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
            $brochureFile1=$form->get('cv')->getData();
            $brochureFile2=$form->get('lettre_motivation')->getData();
            // upload du cv and LM
            $directory=$this->getParameter("personne_directory");
            $stagiaire->setPathCv($uploadsFile->uploadsFile($brochureFile1,$directory,"CV".$stagiaire->getNom()));
            $stagiaire->setPathLettreMotivation($uploadsFile->uploadsFile($brochureFile2,$directory,"LM".$stagiaire->getNom()));
            $entityManager=$doctrine->getManager(); 
            $entityManager->persist($stagiaire);
            $entityManager->flush();
            return $this->redirectToRoute('app_stagiaire.listCandidature');
        }
        return $this->render('stagiaire/candidature.html.twig', [
            'form' => $form->createView(),
            'active_page' => 'candidature',
        ]);
    }
    #[Route('/stagiaire/candidatureSup', name: 'app_stagiaire.canditatureSup')]
    public function addCandidatureSup(
            ManagerRegistry $doctrine,
            Request $request ,
            UploadsFile $uploadsFile,
            StagiaireRepository $stagiaireRepository,
    ): Response
    {
        $stagiaire = new Stagiaire();
        $form=$this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
            $brochureFile1=$form->get('cv')->getData();
            $brochureFile2=$form->get('lettre_motivation')->getData();
            // upload du cv and LM
            $directory=$this->getParameter("personne_directory");
            $stagiaire->setPathCv($uploadsFile->uploadsFile($brochureFile1,$directory,"CV".$stagiaire->getNom()));
            $stagiaire->setPathLettreMotivation($uploadsFile->uploadsFile($brochureFile2,$directory,"LM".$stagiaire->getNom()));
            $entityManager=$doctrine->getManager(); 
            $entityManager->persist($stagiaire);
            $entityManager->flush();
            return $this->redirectToRoute('app_stagiaire.listCandidature');
        }
        return $this->render('stagiaire/candidature.html.twig', [
            'form' => $form->createView(),
            'active_page' => 'candidature',
        ]);
    }
    #[Route('/stagiaire/candidature/list', name: 'app_stagiaire.listCandidature')]
    public function listCandidature(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Stagiaire::class)->findBy(['is_accept'=>0]);
        return $this->render('stagiaire/list.html.twig', [
            'stagiaires' => $repository,
            'active_page' => 'list',
        ]);
    }
    
    #[Route('/stagiaire/candidature/detail/{id}', name: 'app_stagiaire.detailCandidature')]
    public function detailCandidature( Helpers $helpers,Request $request,EntityManagerInterface $entityManager, ManagerRegistry $doctrine,$id): Response
    {
        $stagiaire = $entityManager->getRepository(Stagiaire::class)->find($id);
        $form= $this->createForm(HistoriqueType::class);// on utilise la form hitorique type pour ne paceer un nouveau et la on va recuperer l'encadreur avec 'receveur'
        $form->handleRequest($request);
        if ( $form->isSubmitted()&& $form->isValid()){
            $encadreur=$form->get("receveur")->getData();
            $stagiaire->setEncadreur($encadreur);
            $stagiaire->setIsAccept(1);
            
            $mdp=$helpers->genererMotDePasse();
            $user = new User();
            // substr($stagiaire->getNom(), 2, 2).substr($stagiaire->getPrenom(), 1, 2).substr(uniqid(),10,2)
            $user->setMatricule(strtoupper($stagiaire->getNom()));
            $user->setNom($stagiaire->getNom());
            $user->setPrenom($stagiaire->getPrenom());
            $user->setEmail($stagiaire->getEmail());
            $user->setPassword($this->hasher->hashPassword($user, $mdp));
            $a=$doctrine->getManager()->persist($user);
            $entityManager->flush();
            $this->addFlash('success',"Le stagiaire ".$stagiaire->getNom()." à pour encadreur ".$encadreur.".".$user->getMatricule()."/".$mdp);
            return $this->redirectToRoute('app_stagiaire.listCandidature');
        }
       
        $repository=$doctrine->getRepository(Stagiaire::class)->find($id);
         
         return $this->render('stagiaire/detail.html.twig', [
            'stagiaire' => $repository,
            'form' => $form->createView(),
            'active_page' => 'detail',
        ]);
    }
    #[Route('/stagiaire/candidature/delete/{id}', name: 'app_stagiaire.deleteCandidature')]
    public function deleteCandidature(ManagerRegistry $doctrine,$id): Response{
        $repository=$doctrine->getRepository(Stagiaire::class)->find($id);
        $entityManager=$doctrine->getManager();
        $entityManager->remove($repository);
        $entityManager->flush();
        return $this->redirectToRoute('app_stagiaire.listCandidature');
    }
    // #[Route('/stagiaire/candidature/accept/{id}', name: 'app_stagiaire.acceptCandidature')]
    // public function acceptCandidature($id, EntityManagerInterface $entityManager, Request $request): Response{
    //     $stagiaire = $entityManager->getRepository(Stagiaire::class)->find($id);
    //     $form= $this->createForm(TuteurFormType::class);
    //     $form->handleRequest();
    //     if ($form->isValid() && $form->isSubmitted()){
            
    //         $stagiaire->setEncadreur($form->get("encadreur")->getData());
    //         $stagiaire->setIsAccept(1);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_stagiaire.listCandidature');
    //     }
        
    // }
    #[Route('/stagiaire/candidature/rejet/{id}', name: 'app_stagiaire.rejetCandidature')]
    public function rejetCandidature($id, EntityManagerInterface $entityManager): Response{
        $stagiaire = $entityManager->getRepository(Stagiaire::class)->find($id);
        $stagiaire->setIsAccept(-1);
        $entityManager->flush();
        return $this->redirectToRoute('app_stagiaire.listCandidature');
    }
    #[Route('/stagiaire/encadreur/list', name: 'app_stagiaire.encadreurList')]
    public function encadreurList($id, EntityManagerInterface $entityManager): Response{
        $stagiaire = $entityManager->getRepository(Stagiaire::class)->find($id);
        $stagiaire->setIsAccept(-1);
        $entityManager->flush();
        return $this->render("stagiaire/encadreurList.html.twig");
    }


}
