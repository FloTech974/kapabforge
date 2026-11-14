<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
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
}
