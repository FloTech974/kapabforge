<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CourseRepository;
use App\Repository\NewsRepository;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CourseRepository $courseRepository, NewsRepository $newsRepository): Response
    {
        $courses = $courseRepository->findBy(
                    ['isPublished' => true],
                    ['createdAt' => 'DESC'],
                    4
                );
        $news = $newsRepository->findBy(
            ['isPublished' => true],
            ['createdAt' => 'DESC'],
            4
        );

        return $this->render('home/index.html.twig', [
            'courses' => $courses,
            'news' => $news,
        ]);
    }
}
