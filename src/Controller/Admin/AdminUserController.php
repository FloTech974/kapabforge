<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminUserController extends AbstractController
{
    #[Route('/admin/users', name: 'app_admin_users')]
    public function users(UserRepository $repository): Response
    {
        $users = $repository->findBy(
                [],
                ['createdAt' => 'DESC']
            ); 

        return $this->render('admin/users/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/users/toggle/{id}', name: 'app_admin_toggleuser')]
    public function toggleUser(User $user, EntityManagerInterface $manager): Response
    {
        $user->setIsDisabled(!$user->isDisabled());
        $manager->flush();
        $this->addFlash('info', $user->isDisabled() ? 'L\'utilisateur est maintenant désactivé.' : 'L\'utilisateur est maintenant actif.');

        return $this->redirectToRoute('app_admin_users');
    }
}
