<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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

    #[IsGranted("ROLE_SUPER_ADMIN")]
    #[Route('/admin/users/toggle/{id}', name: 'app_admin_toggleuser')]
    public function toggleUser(User $user, EntityManagerInterface $manager): Response
    {
        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
            $this->addFlash('error', 'Un super administrateur ne peut pas être désactivé');

            return $this->redirectToRoute('app_admin_users');
        }

        $user->setIsDisabled(!$user->isDisabled());
        $manager->flush();
        $this->addFlash('info', $user->isDisabled() ? 'L\'utilisateur est maintenant désactivé.' : 'L\'utilisateur est maintenant actif.');

        return $this->redirectToRoute('app_admin_users');
    }
}
