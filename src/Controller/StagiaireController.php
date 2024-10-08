<?php

namespace App\Controller;

use App\Entity\Evaluation;
use App\Entity\Stage;
use App\Entity\Stagiaire;
use App\Entity\Tache;
use App\Entity\User;
use App\Form\EvaluationType;
use App\Form\HistoriqueType;
use App\Form\RechercheStagiaireType;
use App\Form\StageType;
use App\Form\StagiaireSecType;
use App\Form\StagiaireType;
use App\Form\TacheType;
use App\Form\TuteurFormType;
use App\Repository\EvaluationRepository;
use App\Repository\StagiaireRepository;
use App\Repository\TacheRepository;
use App\Service\Helpers;
use App\Service\MailerService;
use App\Service\UploadsFile;
use Doctrine\ORM\EntityManager;
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
    #[Route('/stagiaire/candidatureSec/{id?0}', name: 'app_stagiaire.canditatureSec')]
    public function addCandidatureSec(
            Int $id,
            ManagerRegistry $doctrine,
            Request $request ,
            UploadsFile $uploadsFile,
            StagiaireRepository $stagiaireRepository,
            MailerService $mailerService
    ): Response
    {
        $create=false;
        $stagiaire=$doctrine->getRepository(Stagiaire::class)->find($id);
        if (!$stagiaire){
            $stagiaire = new Stagiaire();
            $create=true;
        }
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
            if ($create) {
                $subject='Reception de Demande de stage ';
                $message = ' votre demande de candidature a bien été prise en compte.';
            }else{
                $subject='Modification d\'Informations';
                $message = 'Vos informations ont bien été modifiées.';
              
            }
            $mailMessage = 'Mr / Mme '.$stagiaire->getPrenom().' '.$stagiaire->getNom().$message;
            if($mailerService->sendEmail(to:$stagiaire->getEmail(),content:$mailMessage,subject:$subject)
            ){
                $this->addFlash('success', 'Operation reussie , vous allez recevoir un message de confirmation part mail');
            }
            return $this->redirectToRoute('app_stagiaire.listCandidature');
        }
        if (!$create) {
            return $this->render('stagiaire/candidature.html.twig', [
                'form' => $form->createView(),
                'active_page' => 'candidature',
                'variable'=>'Mettre à jour Vos informations',
            ]);
        }
        return $this->render('stagiaire/candidature.html.twig', [
            'form' => $form->createView(),
            'active_page' => 'candidature',
            'variable'=>'Demande de Stage',
        ]);
    }
    #[Route('/stagiaire/candidatureSup/{id?0}', name: 'app_stagiaire.canditatureSup')]
    public function addCandidatureSup(
            Int $id,
            ManagerRegistry $doctrine,
            Request $request ,
            UploadsFile $uploadsFile,
            StagiaireRepository $stagiaireRepository,
            MailerService $mailerService
    ): Response
    {
        $create = false;
        $stagiaire=$doctrine->getRepository(Stagiaire::class)->find($id);
        if (!$stagiaire){
            $stagiaire = new Stagiaire();
            $create=true;
        }
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
            if ($create) {
                $subject='Reception de Demande de stage ';
                $message = ' votre demande de candidature a bien été prise en compte.';
            }else{
                $subject='Modification d\'Informations';
                $message = 'Vos informations ont bien été modifiées.';
              
            }
            $mailMessage = 'Mr / Mme '.$stagiaire->getPrenom().' '.$stagiaire->getNom().$message;
            if($mailerService->sendEmail(to:$stagiaire->getEmail(),content:$mailMessage,subject:$subject)
            ){
                $this->addFlash('success', 'Operation reussie , vous allez recevoir un message de confirmation part mail');
            }
            return $this->redirectToRoute('app_stagiaire.listCandidature');
        }
        if (!$create) {
            return $this->render('stagiaire/candidature.html.twig', [
                'form' => $form->createView(),
                'active_page' => 'candidature',
                'variable'=>'Mettre à jour Vos informations',
            ]);
        }
        return $this->render('stagiaire/candidature.html.twig', [
            'form' => $form->createView(),
            'active_page' => 'candidature',
            'variable'=>'Demande de Stage',
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
    #[Route('/stagiaire/list/candidature/refuser', name: 'app_stagiaire.listCandidatureRefuser')]
    public function listCandidatureRefuser(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Stagiaire::class)->findBy(['is_accept'=>-1]);
        return $this->render('stagiaire/listRefuser.html.twig', [
            'stagiaires' => $repository,
            'active_page' => 'list',
        ]);
    }
    
    #[Route('/stagiaire/candidature/detail/{id}', name: 'app_stagiaire.detailCandidature')]
    public function detailCandidature( Helpers $helpers,Request $request,EntityManagerInterface $entityManager, ManagerRegistry $doctrine,$id, MailerService $mailerService): Response
    {
        $stagiaire = $entityManager->getRepository(Stagiaire::class)->find($id);
        $form= $this->createForm(HistoriqueType::class);// on utilise la form hitorique type pour ne paceer un nouveau et la on va recuperer l'encadreur avec 'receveur'
        $form->handleRequest($request);
        if ( $form->isSubmitted()&& $form->isValid()){
            $encadreur=$form->get("receveur")->getData();
            $stagiaire->setEncadreur($encadreur);
            $stagiaire->setIsAccept(1);
            
            $mdp=$helpers->genererMotDePasse();
            //creation de L'utilisateur
            // substr($stagiaire->getNom(), 2, 2).substr($stagiaire->getPrenom(), 1, 2).substr(uniqid(),10,2)
            $user = new User();
            $user->setMatricule(strtoupper($stagiaire->getNom()));
            $user->setNom($stagiaire->getNom());
            $user->setPrenom($stagiaire->getPrenom());
            $user->setEmail($stagiaire->getEmail());
            $user->setPassword($this->hasher->hashPassword($user, $mdp));
            $user->setStagiaire($stagiaire);
            $user->setRoles(['ROLE_STAGIAIRE']);
            // creation du stage 
            $stage=new Stage();
            $stage->setStagiaire($stagiaire);
            $stage->setDateDebut($stagiaire->getDateDebut());
            $stage->setDateFin($stagiaire->getDateFin());
            
            $doctrine->getManager()->persist($user);
            $doctrine->getManager()->persist($stage);
            $entityManager->flush();
            
                $subject='Acception de demande de stage ';
                $message = "Votre demande demande de stage à été accepté. \n \t
                             Veillez vous prensentez au Cenadi le ".$stagiaire->getDateDebut()->format('Y-m-d')." \n \t 
                              Dans nos locaux, vous pouvez vous connecter à votre compte sur la plateforme : http://localhost:8000/login  \n \t
                             Vos informations de connexion sur la plateforme sont les suivantes. \n \t
                             Nom d'utilisateur : " .$user->getMatricule(). " \n \t
                             Votre mot de passe : " .$mdp. " \n \t
                             Merci pour votre attention " ;
            
            $mailMessage = 'Mr / Mme '.$stagiaire->getPrenom().' '.$stagiaire->getNom().$message;
            if($mailerService->sendEmail(to:$stagiaire->getEmail(),content:$mailMessage,subject:$subject)
            ){
                $this->addFlash('success', 'Operation reussie , un mail à été envoyer au stagiaire');
            }
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
    public function rejetCandidature($id, EntityManagerInterface $entityManager,MailerService $mailerService): Response{
        $stagiaire = $entityManager->getRepository(Stagiaire::class)->find($id);
        $stagiaire->setIsAccept(-1);
        $entityManager->flush();
        $subject='Rejet de demande de stage ';
        $message = "Votre demande demande de stage à été rejeter; réessayer en une autre periode. \n \t
                    <br>
                     Merci pour votre attention " ;
    
    $mailMessage = 'Mr / Mme '.$stagiaire->getPrenom().' '.$stagiaire->getNom().$message;
    if($mailerService->sendEmail(to:$stagiaire->getEmail(),content:$mailMessage,subject:$subject)
    ){
        $this->addFlash('success', 'Operation reussie , un mail à été envoyer au stagiaire');
    }else{
        $this->addFlash('error', 'Erreur lors de l\'envoi du mail');
    }
    
    
        return $this->redirectToRoute('app_stagiaire.listCandidature');
    }
    #[Route('/stagiaire/encadreur/list', name: 'app_stagiaire.encadreurList')]
    public function encadreurList( EntityManagerInterface $entityManager): Response{
        
        return $this->render("stagiaire/encadreurList.html.twig",[
            'active_page' => 'stagiaire',
        ]);
    } 
    #[Route('/stagiaire/historique/list', name: 'app_stagiaire.historiqueList')]
    public function historiqueList( ManagerRegistry $doctrine,Request $request,StagiaireRepository $stagiaireRepository): Response{
        
        $form = $this->createForm(RechercheStagiaireType::class);
        $form->handleRequest($request);
        $data=[];
        $data=$form->getData();
        
        return $this->render("stagiaire/stagiaire.html.twig",[
            'active_page' => 'stagiaire',
            'stagiaires' => $stagiaireRepository->findByData($data),
            'form'=>$form->createView(),
        ]);
    } 
    #[Route('/stagiaire/stage/{id}', name: 'app_stagiaire.stage')]
    public function stagiaireStage($id, Request $request,EntityManagerInterface $manager, ManagerRegistry $doctrine,EvaluationRepository $evaluationRepository): Response{
        $stage=$manager->getRepository(Stage::class)->find($id);
        $stage->getStagiaire();
        $form=$this->createForm(StageType::class, $stage);
        $form->handleRequest($request);
        //$evaluation = $evaluationRepository->findByStageId($id);

        if($form->isSubmitted() && $form->isValid())
        {
            
            $entityManager=$doctrine->getManager();
            $entityManager->persist($stage);
            $entityManager->flush();
            $this->addFlash('success',"Stage Modifié avec success");
            return $this->redirectToRoute('app_stagiaire.encadreurList');
        

        }
        return $this->render("stagiaire/stage.html.twig",[
            'active_page' => 'stage',
            'form'=>$form->createView(),
            'stagiaire'=>$stage->getStagiaire(),
            'note'=>00,
           // 'note'=>$evaluation->calculerNoteSur20(),
        ]);
    } 
    #[Route('/stagiaire/evaluation/{id<\d+>}/{evaluationId?0}', name: 'app_stagiaire.evaluation')]
    public function EvaluationStagiaire($id,int $evaluationId,Request $request,ManagerRegistry $doctrine, EvaluationRepository $evaluationRepository, EntityManagerInterface $entityManager): Response{
        $evaluation = $evaluationRepository->findStageByEvaluationId($id,$evaluationId);
        // dd($evaluation->calculerNoteSur20());
        if (!$evaluation) {
        $evaluation = new Evaluation();
        }
        $form=$this->createForm(EvaluationType::class, $evaluation);
        $form->handleRequest($request);
        $stage=$doctrine->getRepository(Stage::class)->find($id);
        //$stage = $entityManager->getRepository(Stage::class)->find($id);
        $evaluation->setStage($stage); // on met l'id du stagiaire en cours en evaluation
            if($form->isSubmitted() && $form->isValid()){

            $entityManager=$doctrine->getManager();
            $entityManager->persist($evaluation);
            $entityManager->flush();
            $this->addFlash('success',"Evaluation enregistrée");
            return $this->redirectToRoute('app_stagiaire.encadreurList');
        }
        
        return $this->render("stagiaire/evaluation.html.twig",[
            'active_page' => 'stagiaire',
            'evaluation' => $evaluation,
           'form' => $form->createView(),
        ]);
    }
    #[Route("/stagiaire/evaluation/fiche/{id}", name:"app_stagiaire.evaluationFiche")]
    public function evaluationFiche($id, ManagerRegistry $doctrine): Response
    {   $evaluation= $doctrine->getRepository(Evaluation::class)->find($id);
        // Les éléments de suivi et leurs mentions
        $elementsSuivi = [
            'assiduite' => $evaluation->getAssuiduite(),
            'ponctualite' => $evaluation->getPonctualite(),
            'disponibilite, propreté et respect des règles de sécurité' => $evaluation->getDisponibilite(),
            'intérêt pour l\'entreprise' => $evaluation->getInteret(),
            'respect de la hiérachie ' => $evaluation->getRespect(),
            'esprit d\'equipe et d\'initiative' => $evaluation->getEsprit(),
            'aptitude à l\'exécution des tâches' => $evaluation->getAptitude(),
            'organisation de son poste de travail' => $evaluation->getOrganisation(),
            'application et soin à l\'éxécution des tâches ' => $evaluation->getApplication(),
            'recherche et progression dans le thème (rendement)' => $evaluation->getRecherche(),
        ];

        // Les mentions possibles
        $mentions = [  'insuffisant','passable','assez_bien','bien', 'tres_bien','excellent'];

        return $this->render('stagiaire/evaluationFiche.html.twig', [
            'elementsSuivi' => $elementsSuivi,
            'mentions' => $mentions,
            'evaluation' => $evaluation,
            'active_page'=>'evaluationFiche',
        ]);
    }
    #[Route('/stagiaire/info', name: 'app_stagiaire.stageInfo')]
    public function stageInfo( request $request, ManagerRegistry $doctrine, UploadsFile $uploadsFile): Response{
        foreach ($this->getUser()->getStagiaire()->getStages() as $stage)
        {
        $stage= $doctrine->getRepository(Stage::class)->find($stage->getId());

        }
        $form=$this->createForm(StageType::class, $stage);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(!empty($form->get('rapport')->getData())){
                $brochureFile1=$form->get('rapport')->getData();
            $directory=$this->getParameter("rapport_directory");
            $stage->setRapport($uploadsFile->uploadsFile($brochureFile1,$directory,$stage->getTheme()));
            }
            
            $entityManager=$doctrine->getManager();
            $entityManager->persist($stage);
            $entityManager->flush();

        }
        
        return $this->render("stagiaire/stagiaireInfo.html.twig",[
            'active_page' => 'stagiaire',
            'form' => $form->createView(),
            
        ]);
    } 
   
    #[Route('/stagiaire/planifierTache/{id}/{tacheId?0}', name: 'app_stagiaire.planifierTache')]
    public function planifierTaches($id, int $tacheId, ManagerRegistry $doctrine, Request $request): Response
    {
        $tache=$doctrine->getRepository(Tache::class)->find($tacheId);
        if (!$tache) {
            $tache = new Tache(); 
        }
        $stagiaire = $doctrine->getRepository(Stagiaire::class)->find($id);
        $tache->setStagiaire($stagiaire);

        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($tache);
            $entityManager->flush();

            $this->addFlash('success', 'La tâche a été planifiée avec succès.');

            return $this->redirectToRoute('app_stagiaire.planifierTache', ['id' => $stagiaire->getId()]);
        }

        return $this->render('stagiaire/planifier.html.twig', [
            'stagiaire' => $stagiaire,
            'form' => $form->createView(),
            'active_page' => 'planifierTache',
        ]);
    
    }
    
    #[Route('/stagiaire/timeline/{id}', name: 'app_stagiaire.timeline')]
    public function timeline($id, ManagerRegistry $doctrine, TacheRepository $tacheRepository, EntityManagerInterface $entityManager): Response
    {
        $stagiaire = $entityManager->getRepository(Stagiaire::class)->find($id);
        // Récupération des tâches du stagiaire
        $taches = $tacheRepository->findBy(['stagiaire' => $stagiaire], ['date_debut' => 'DESC']);
        $date = new \DateTime;
        foreach ($taches as $tache){
            if($tache->getStatut() == "a_faire" and $tache->getDateDebut() < $date){
                
                $tache->setStatut("en_cours");
                $entityManager->flush();
               
            }
        }
        
        

        // Rendu de la vue Twig en passant les données nécessaires
        return $this->render('stagiaire/timeline.html.twig', [
            'stagiaire' => $stagiaire,
            'taches' => $taches,
            'date' => $date,
            'active_page' => 'timeline',
        ]);
    }
    #[Route('/stagiaire/tache/changerStatut/{id}', name: 'app_stagiaire.tacheChangerStatut')]
    public function changerStatut($id, EntityManagerInterface $entityManager): Response
    {
        $tache = $entityManager->getRepository(Tache::class)->find($id);
        // Récupération du nouveau statut envoyé via le formulaire
        $nouveauStatut = $_POST['nouveau_statut'];
        if ($nouveauStatut =="termine"){
            $date = new \DateTime();
            $tache->setDateFinReel($date);


        }
        // Mise à jour du statut de la tâche
        $tache->setStatut($nouveauStatut);
        // Sauvegarde des modifications en base de données
        $entityManager->flush();
        
        // Redirection vers la page de la timeline ou une autre page
        return $this->redirectToRoute('app_stagiaire.timeline', ['id' => $tache->getStagiaire()->getId()]);
    }
   
    #[Route('/stagiaire/tache/rapport/{id}', name: 'app_stagiaire.tacheRapport')]
    public function rapport($id, EntityManagerInterface $entityManager, TacheRepository $tacheRepository): Response
    {
        $stagiaire = $entityManager->getRepository(Stagiaire::class)->find($id);
        // Récupération des tâches du stagiaire
        $taches = $tacheRepository->findBy(['stagiaire' => $stagiaire], ['date_fin' => 'ASC']);

        return $this->render('stagiaire/tacheRapport.html.twig', [
            'stagiaire' => $stagiaire,
            'taches' => $taches,
            'active_page' => 'rapportStagiaire',
        ]);
    }
    
    #[Route('/stagiaire/evaluation/list/{id<\d+>}', name: 'app_stagiaire.evaluationList')]
    public function listEvaluationStagiaire($id, EntityManagerInterface $entityManager): Response
    {
        $stage=$entityManager->getRepository(Stage::class)->find($id);
        // Récupérer les évaluations du stagiaire
        $evaluations = $stage->getEvaluations();

        // Rendre la vue avec les évaluations
        return $this->render('stagiaire/listEvaluation.html.twig', [
            'stage' => $stage,
            'evaluations' => $evaluations,
            'active_page' => 'evaluationList',
        ]);
    }
   

}
