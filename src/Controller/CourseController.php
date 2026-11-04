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

    #[Route('/course/{slug}', name: 'app_course')]
    public function course(string $slug, CourseRepository $repository): Response
    {
        $course = $repository->findOneBy([
            'slug' => $slug,
            'isPublished' => true,
        ]);

        if (!$course) {
            throw $this->createNotFoundException('Formation non trouvée');
        }

        return $this->render('course/course.html.twig', [
            'course' => $course,
        ]);
    }

    #[Route('/courses/{slug}', name: 'app_courses_cat')]
    public function courseCat(string $slug, CourseRepository $repository): Response
    {
        $courses = $repository->findByCategory($slug);

        return $this->render('course/courses.html.twig', [
            'courses' => $courses,
        ]);
    }
}