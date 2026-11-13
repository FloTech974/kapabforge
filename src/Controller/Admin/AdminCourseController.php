<?php

namespace App\Controller\Admin;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Course;
use App\Form\CourseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;


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

    #[Route('/admin/courses/newcourse', name: 'app_admin_newcourse')]
    public function newCourse(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $course->setCreatedAt(new \DateTimeImmutable());
            $course->setUpdatedAt(new \DateTimeImmutable());
            $course->setSlug($slugger->slug($course->getName())->lower());
            $manager->persist($course); 
            $manager->flush();
            $this->addFlash('success', 'La formation a été créée avec succès.');

            return $this->redirectToRoute('app_admin_courses');
        }

        return $this->render('admin/courses/newcourse.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/courses/delete/{id}', name: 'app_admin_deletecourse')]
    public function deleteCourse(Course $course, EntityManagerInterface $manager): Response
    {
        $manager->remove($course);
        $manager->flush();
        $this->addFlash('warning', 'La formation a été supprimée avec succès.');

        return $this->redirectToRoute('app_admin_courses');
    }

    #[Route('/admin/courses/edit/{id}', name: 'app_admin_editcourse')]
    public function editCourse(Course $course, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $course->setUpdatedAt(new \DateTimeImmutable());
            $course->setSlug($slugger->slug($course->getName())->lower());
            $manager->flush();
            $this->addFlash('success', 'La formation a été modifiée avec succès.');

            return $this->redirectToRoute('app_admin_courses');
        }

        return $this->render('admin/courses/editcourse.html.twig', [
            'form' => $form,
            'course' => $course,
        ]);
    }

    #[Route('/admin/courses/view/{id}', name: 'app_admin_viewcourse')]
    public function viewCourse(Course $course, EntityManagerInterface $manager): Response
    {
        $course->setIsPublished(!$course->isPublished());
        $manager->flush();
        $this->addFlash('info', $course->isPublished() ? 'La formation est maintenant visible.' : 'La formation est maintenant masquée.');

        return $this->redirectToRoute('app_admin_courses');
    }
}
