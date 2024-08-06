<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(User::class)->findALl();
        
        return $this->render('user/index.html.twig', [
            'users' =>$repository,
            'active_page' =>'user'
        ]);
    }

    #[Route('/notifications/count', name: 'notifications_count', methods: ['GET', 'POST'])]
    public function countUnread(EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['count' => 0]);
        }

        $notificationRepository = $entityManager->getRepository(Historique::class);
        $unreadNotificationsCount = $notificationRepository->count(['receveur' => $this->getUser(), 'is_read' => false]);

        return new JsonResponse(['count' => $unreadNotificationsCount]);
    }
    #[Route('/user/verify', name: 'user_verify', methods: ['GET', 'POST'])]
    public function countUnVerify(EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['count' => 0]);
        }

        $userRepository = $entityManager->getRepository(User::class);
        $unreadusersCount = $userRepository->count(['isVerified' => false]);

        return new JsonResponse(['count' => $unreadusersCount]);
    }
    #[Route('/user/verify/{id}', name: 'app_user.verify')]
    public function verifyUser($id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
        $user->setIsVerified(true);
        $entityManager->flush();
        return $this->redirectToRoute('app_user');
    }

}
