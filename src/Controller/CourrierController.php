<?php

namespace App\Controller;

use App\Entity\Courrier;
use App\Entity\PieceJointe;
use App\Entity\User;
use App\Form\CourrierType;
use App\Form\PieceJointeType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class CourrierController extends AbstractController
{
    public function __construct(
        
        private UserPasswordHasherInterface $hasher
    )
    {
        
    }
    #[Route('/courrier', name: 'app_courrier')]
    public function index(): Response
    {
        return $this->render('courrier/index.html.twig', [
            'controller_name' => 'CourrierController',
        ]);
    }
    #[Route('/courrier/add', name: 'app_courrier.add')]
    public function addCouu(ManagerRegistry $doctrine, Request $request): Response
    {

    

        // $manager =$manager->getManager();
        // $admin1 = new User();
        // $admin1->setEmail('admin1@gmail.com')
        // ->setMatricule("admin1")
        // ->setNom("Admin1")
        // ->setPrenom("Admin1")
        // ->setRoles(['ROLE_ADMIN'])
        // ->setPassword($this->hasher->hashPassword($admin1, 'admin1'));

        // $manager->persist($admin1);
        // $admin2 = new User();

        // $admin2->setEmail('admin2@gmail.com')
        // ->setNom("Admin2")
        // ->setMatricule("admin2")
        // ->setPrenom("Admin2")
        // ->setRoles(['ROLE_ADMIN'])
        // ->setPassword($this->hasher->hashPassword($admin2, 'admin2'));
        
        // $manager->persist($admin2);

        // for ($i=1; $i < 5; $i++) { 
        //     $user = new User();
        //     $user->setMatricule("user$i");
        //     $user->setNom("User $i");
        //     $user->setPrenom("Prenom $i");
        //     $user->setEmail("user$i@gmail.com");
        //     $user->setPassword($this->hasher->hashPassword($user, 'user'));
        //     $manager->persist($user);
        // }

        

        // $manager->flush();

            $courrier=new Courrier();
            $pieceJointe=new PieceJointe();
            $form = $this->createForm(CourrierType::class, $courrier);
            $formP= $this->createForm(PieceJointeType::class, $pieceJointe);
             $form->handleRequest($request);
             $formP->handleRequest($request);
            // Mon formulaire va aller traiter la requete 

            if($form->isSubmitted() && $form->isValid() && $formP->isSubmitted() && $formP->isValid()){
                // si mon formulaire est soumis, on ajoute ,
                // redige vers les courrier, et messages success
                
                $entityManager=$doctrine->getManager(); 
                 $entityManager->persist($courrier);
                 $entityManager->persist($pieceJointe);
              
                
                $entityManager->flush();
                
             
        return $this->render('courrier', [
            
            
        ]);
    }
    return $this->render('courrier/add.html.twig', [
        'form' => $form->createView(),
        'formP' => $formP->createView(),
        
    ]);
}}
