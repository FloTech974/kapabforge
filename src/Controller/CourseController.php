<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CourseRepository;

final class CourseController extends AbstractController
{
    #[Route('/courses', name: 'app_courses')]
    public function courses(CourseRepository $repository): Response
    {
        $courses = $repository->findBy(
            ['isPublished' => true],
            ['createdAt' => 'DESC'],
        );

        return $this->render('course/courses.html.twig', [
            'courses' => $courses,
        ]);
    }
}
