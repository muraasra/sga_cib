<?php

namespace App\Controller;

use App\Entity\Controle;
use App\Entity\Courrier;
use App\Entity\Historique;
use App\Entity\PieceJointe;
use App\Entity\Pv;
use App\Entity\User;
use App\Form\ControleType;
use App\Form\CourrierDepartType;
use App\Form\CourrierType;
use App\Form\HistoriqueType;
use App\Form\PieceJointeType;
use App\Form\RechercheType;
use App\Form\SearchType;
use App\Repository\ControleRepository;
use App\Repository\CourrierRepository;
use App\Service\MailerService;
use App\Service\UploadsFile;
use App\Service\UploadsImage;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
            'active_page' => 'accueil',
        ]);
    }
    #[Route('/courrier/list', name: 'app_courrier.list')]
    public function listCourrier(ManagerRegistry $doctrine, Request $request, CourrierRepository $courrierRepository): Response
    {
        $form=$this->createForm(RechercheType::class);
        $form->handleRequest($request);
        $data=[];
        // if($form->isSubmitted()){
            $data=$form->getData();

        // }
        return $this->render('courrier/list.html.twig', [
            'courriers' => $courrierRepository->findByData($data),
            'form' => $form->createView(),
            'active_page' => 'list'
        ]);
    }
    #[Route('/courrier/recu', name: 'app_courrier.recu')]
    public function recevoir(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Courrier::class)->findAll();
        return $this->render('courrier/recu.html.twig',[
            'active_page' => 'recu'
        ]);
    }
    #[Route('/courrier/pdf/{id}', name: 'app_courrier.pdf')]
    public function voir(ManagerRegistry $doctrine, $id): Response
    {
        $repository = $doctrine->getRepository(Courrier::class)->find($id);
        $dompdf = new Dompdf();
        $html=$this->render('courrier/pdf.html.twig',[
            'courrier' => $repository ]);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();


        return new 
        Response ( $dompdf->stream("courrier.pdf",
        ["Attachment"=>1]));
        
    
    }
    #[Route('/courrier/view/{id}', name: 'app_courrier.view')]
    public function pdf(ManagerRegistry $doctrine, $id): Response
    {
       $historique = $doctrine->getRepository(Historique::class)->find($id);
       $historique-> setIsRead(true);
       $entityManager=$doctrine->getManager();
       $entityManager->persist($historique);
       $entityManager->flush();
       $repository = $doctrine->getRepository(Courrier::class)->find($historique->getCourrierId());
       
        return $this->render('courrier/view.html.twig',[
            'courrier' => $repository,
            'active_page' => 'view',
            
        ]);
    }
    #[Route('/courrier/listview/{id}', name: 'app_courrier.listview')]
    public function listview(ManagerRegistry $doctrine, $id, Request $request, EntityManagerInterface $entityManager,UploadsFile $uploadsFile, ControleRepository $controleRepository): Response
    {
       
       $repository = $doctrine->getRepository(Courrier::class)->find($id);
       if($repository->getTypeCourrier() == "Controle" ){
        $demandeControles = $controleRepository->findByCourrierDemandeId($id);
        
        $demandeControle =$entityManager->getRepository(Controle::class)->find($demandeControles[0]->getId());
        // $pvControle = $entityManager->getRepository(Pv::class)->find($demandeControle->getCourrierDemande());
        $pvControle = new Pv();
        //dd($demandeControle->getCourrierDemande());
        $pvControle->setCourrierDemande($demandeControle);
        
        $form = $this->createForm(ControleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion du statut
            $statut = $form->get('statut')->getData();

            // Si accepté, on traite l'import du PV
            if ($statut == 'accepte') {
                $demandeControle->setStatutDemande(true);
                $demandeControle->setStatutControle(true);

                $pvFile = $form->get('pv')->getData();

                if ($pvFile) {
                $directory=$this->getParameter("controle_directory");
                $pvControle->setPathPv($uploadsFile->uploadsFile($pvFile,$directory,$demandeControle->getCourrierDemande()->getExpediteur()));
                  
                }
                
            } elseif ($statut == "refuse")  {
                // Si refusé, on supprime le fichier PV (s'il existe)
                $demandeControle->setStatutDemande(true);
                $demandeControle->setStatutControle(false);

                $pvControle->setPathPv(null);
            }

            // Enregistrer les modifications dans la base de données
            $entityManager->flush();
            $this->addFlash('success','Vous avez ajouter les resultats du controle avec success ');
            return $this->redirectToRoute('app_courrier.listview',['id' => $id]); // Redirection vers la liste des contrôles
        }

        return $this->render('courrier/view.html.twig', [
            'form' => $form->createView(),
            'courrier' => $repository,
            'active_page' => 'view',
            
        ]);
       }
        return $this->render('courrier/view.html.twig',[
            'courrier' => $repository,
            'active_page' => 'view',
            
        ]);
    }
    #[Route('/courrier/transfert/{id}', name: 'app_courrier.transfert')]
   public function transfertCourrier($id , ManagerRegistry $doctrine , Request $request){
        
        $courrier = $doctrine->getRepository(Courrier::class)->find($id);
        $Historique=new Historique();
       
            $form = $this->createForm(HistoriqueType::class, $Historique);
             $form->handleRequest($request);
            // Mon formulaire va aller traiter la requete 
            if (!$courrier) {
                throw $this->createNotFoundException(
                    'No courrier found for id '.$id
                );
            }
            if($form->isSubmitted() && $form->isValid() ){
                // si mon formulaire est soumis, on ajoute ,
                // redige vers les Historique, et messages success
                
                 
                 $Historique->setCourrierId($courrier);
                 $Historique->setAction("Transferté");
                 $Historique->setDate(new \DateTime());
                 $Historique->setEnvoyeur($this->getUser());
         
                 $entityManager=$doctrine->getManager(); 
                 $entityManager->persist($Historique);
                 $entityManager->flush();
                
                
             
                 return $this->redirectToRoute('app_courrier.list');
    }
       
    return $this->render('courrier/transfert.html.twig', [
        'form' =>$form->createView(),
        'courrier' => $courrier,
        'active_page' => 'list'
    ]);
    }
    #[Route('/courrier/reception/{id}', name: 'app_courrier.reception')]

   
    #[Route('/courrier/add', name: 'app_courrier.add')]
    public function addCourrier(ManagerRegistry $doctrine,
                                MailerService $mailerService,
                                 Request $request ,
                                 UploadsFile $uploadsFile,
                                 SluggerInterface $slugger,
                                 #[Autowire('%kernel.project_dir%/public/uploads/brochures')] string $brochuresDirectory,
                                 CourrierRepository $courrierRepository): Response
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
            $form = $this->createForm(CourrierType::class, $courrier);
             $form->handleRequest($request);
            // Mon formulaire va aller traiter la requete 

            if($form->isSubmitted() && $form->isValid() ){
                
                // si mon formulaire est soumis, on ajoute ,
                // redige vers les courrier, et messages success
                $brochureFile=$form->get('brochure')->getData();
                $typeCour =$typeCourrier=$form->get('type_courrier')->getData();
                $dateReception=$form->get('date_reception')->getData();
                $dateReception= ($dateReception)->format('Y');
                

                
                
                // if ($brochureFile) {
                //     $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                //     // this is needed to safely include the file name as part of the URL
                //     // $safeFilename = $slugger->slug($originalFilename);
                //     $newFilename = $courrier->getExpediteur().'-'.uniqid().'.'.$brochureFile->guessExtension();
                //     try {
                //         $brochureFile->move($brochuresDirectory, $newFilename);
                //     } catch (FileException $e) {
                //         // ... handle exception if something happens during file upload
                //         throw $e;
                //     }
                    

                //     // Update the 'brochureFilename' property to store the new filename
                //     $courrier->setPieceJointe($newFilename);
                // }
               
                $typeCourrier=substr($typeCourrier->getType(),0,1);
                //$dateNow= (new DateTime())->format('Y');                
                $nbreCourrierAnnee=sprintf('%03d',(count($courrierRepository->findByDate($dateReception))+1));
                $numeroOdre=trim(htmlspecialchars($nbreCourrierAnnee."/".$dateReception."/".$typeCourrier."/CENADI/CENADI-O"));
                
               
                $courrier->setNumeroOdre($numeroOdre);
                if($brochureFile){
                    $directory=$this->getParameter("personne_directory");
                $courrier->setPieceJointe($uploadsFile->uploadsFile($brochureFile,$directory,$courrier->getExpediteur()));
                 }
                $entityManager=$doctrine->getManager(); 
                 $entityManager->persist($courrier);
                 
                
                $entityManager->flush();
                if ($typeCour->getType() == "Controle") {
                    $demande_controle=new Controle();
                    $demande_controle->setCourrierDemande($courrier);
                    $demande_controle->setStatutDemande(false);
                    $entityManager->persist($demande_controle);
                    $entityManager->flush();

                    $subject=$courrier->getObjet();
                    $message = "Une nouvelle demande de contole a été envoyer pour le cenadi. \n \t
                                <br>
                                 Merci pour votre attention " ;
                $users= $doctrine->getRepository(User::class)->findBy(['roles' => 'ROLE_ADMIN']);
                
                    foreach ($users as $user) {
                        $mailMessage = 'Mr / Mme '.$user->getPrenom().' '.$user->getNom().$message;
                if($mailerService->sendEmail(to:$user->getEmail(),content:$mailMessage,subject:$subject)
                ){
                    $this->addFlash('success', 'Operation reussie , un mail à été envoyer aux admin');
                }else{
                    $this->addFlash('error', 'Erreur lors de l\'envoi du mail');
                }
                    }
                
                }
                $this->addFlash('success',"Le courrier de numero d'ordre : ".$numeroOdre." a été ajouter avec succes");
             
        return $this->redirectToRoute("app_courrier.list");
    }
    return $this->render('courrier/add.html.twig', [
        'form' => $form->createView(),
        'active_page' => 'add',
        'type' => 'Entrant',

        
    ]);
}

#[Route('/courrier/addDepart', name: 'app_courrier.addDepart')]
public function addCourrierDepart(ManagerRegistry $doctrine,
                            MailerService $mailerService,
                            CourrierRepository $courrierRepository,
                             Request $request ,
                             UploadsFile $uploadsFile,
                             SluggerInterface $slugger,
                             #[Autowire('%kernel.project_dir%/public/uploads/brochures')] string $brochuresDirectory
                             ): Response
{


        $courrier=new Courrier();
        $form = $this->createForm(CourrierDepartType::class, $courrier);
         $form->handleRequest($request);
        // Mon formulaire va aller traiter la requete 

        if($form->isSubmitted() && $form->isValid() ){
            
            // si mon formulaire est soumis, on ajoute ,
            // redige vers les courrier, et messages success
            $brochureFile=$form->get('brochure')->getData();
            $typeCour =$typeCourrier=$form->get('type_courrier')->getData();
                $dateReception=$form->get('date_reception')->getData();
                $dateReception= ($dateReception)->format('Y');
            // if ($brochureFile) {
            //     $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
            //     // this is needed to safely include the file name as part of the URL
            //     // $safeFilename = $slugger->slug($originalFilename);
            //     $newFilename = $courrier->getExpediteur().'-'.uniqid().'.'.$brochureFile->guessExtension();
            //     try {
            //         $brochureFile->move($brochuresDirectory, $newFilename);
            //     } catch (FileException $e) {
            //         // ... handle exception if something happens during file upload
            //         throw $e;
            //     }
                

            //     // Update the 'brochureFilename' property to store the new filename
            //     $courrier->setPieceJointe($newFilename);
            // }
            $typeCourrier=substr($typeCourrier->getType(),0,1);
                //$dateNow= (new DateTime())->format('Y');                
                $nbreCourrierAnnee=sprintf('%03d',(count($courrierRepository->findByDate($dateReception))+1));
                $numeroOdre=trim(htmlspecialchars($nbreCourrierAnnee."/".$dateReception."/".$typeCourrier."/CENADI/CENADI-O"));
                
               
                $courrier->setNumeroOdre($numeroOdre);
            if($brochureFile){
                $directory=$this->getParameter("personne_directory");
            $courrier->setPieceJointe($uploadsFile->uploadsFile($brochureFile,$directory,$courrier->getExpediteur()));
             }
            $entityManager=$doctrine->getManager(); 
             $entityManager->persist($courrier);
          
            
            $entityManager->flush();

            if ($typeCour->getType() == "Controle") {
                $demande_controle=new Controle();
                    $demande_controle->setCourrierDemande($courrier);
                    $demande_controle->setStatutDemande(false);
                    $entityManager->persist($demande_controle);
                    $entityManager->flush();
                    
                $subject=$courrier->getObjet();
                $message = "Une nouvelle demande de contole a été envoyer pour le cenadi. \n \t
                            <br>
                             Merci pour votre attention " ;
            $users= $doctrine->getRepository(User::class)->findBy(['roles' => 'ROLE_ADMIN']);
            
                foreach ($users as $user) {
                    $mailMessage = 'Mr / Mme '.$user->getPrenom().' '.$user->getNom().$message;
            if($mailerService->sendEmail(to:$user->getEmail(),content:$mailMessage,subject:$subject)
            ){
                $this->addFlash('success', 'Operation reussie , un mail à été envoyer aux admin');
            }else{
                $this->addFlash('error', 'Erreur lors de l\'envoi du mail');
            }
                }
            
            }
            
         
    return $this->render('courrier', [
        
        
    ]);
}
return $this->render('courrier/add.html.twig', [
    'form' => $form->createView(),
    'active_page' => 'add',
    'type' => 'Sortant',
    
    
]);
}

}
