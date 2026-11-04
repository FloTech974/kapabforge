<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class CategoryController extends AbstractController
{
    public function categories(CategoryRepository $repository, ?string $current = null): Response
    {
        $categories = $repository->findBy([], ['name' => 'ASC']);

        return $this->render('partials/categories.html.twig', [
            'categories' => $categories,
            'current' => $current,
        ]);
    }
}