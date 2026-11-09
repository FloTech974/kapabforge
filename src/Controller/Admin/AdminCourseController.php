<?php

namespace App\Controller\Admin;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class AdminCourseController extends AbstractController
{
    #[Route('/admin/courses', name: 'app_admin_courses')]
    public function courses(CourseRepository $repository): Response
    {
        $courses = $repository->findBy(
            [],
            ['createdAt' => 'DESC']       
        );
        return $this->render('admin/courses/courses.html.twig', [
            'courses' => $courses,
        ]);
    }
}
