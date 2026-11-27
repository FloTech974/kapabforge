<?php

namespace App\Controller\Admin;

use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\News;
// use App\Form\NewsType
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

final class AdminNewsController extends AbstractController
{
    #[Route('/admin/news', name: 'app_admin_news')]
    public function news(NewsRepository $repository): Response
    {
        $news = $repository->findBy(
            [],
            ['createdAt'=> 'DESC']
        );

        return $this->render('admin/news/news.html.twig', [
            'news' => $news,
        ]);
    }

    // #[Route('/admin/news', name: 'app_admin_newnews')]
    // public function newNews(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    // {
    //     $news = new News();
    //     $form = $this->createForm(NewsType::class, $news);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()){
    //         $news->setCreatedAt(new \DateTimeImmutable());
    //         $news->setUpdatedAt(new \DateTimeImmutable());
    //         $news->setSlug($slugger->slug($news->getName())->lower());
    //         $manager->persist($news);
    //         $manager->flush();
    //         $this->addFlash('success', 'L\'article a été créée avec succès.');

    //         return $this->redirectToRoute('app_admin_news');
    //     }

    //     return $this->render('admin/news/newnews.html.twig', [
    //         'form'=> $form,
    //     ]);
    // }

    // #[Route('/admin/news', name: 'app_admin_news')]
    // public function news(NewsRepository $repository): Response
    // {
    //     return $this->render('admin/admin_news/index.html.twig', [
    //         'controller_name' => 'AdminNewsController',
    //     ]);
    // }

    // #[Route('/admin/news', name: 'app_admin_news')]
    // public function news(NewsRepository $repository): Response
    // {
    //     return $this->render('admin/admin_news/index.html.twig', [
    //         'controller_name' => 'AdminNewsController',
    //     ]);
    // }

    // #[Route('/admin/news', name: 'app_admin_news')]
    // public function news(NewsRepository $repository): Response
    // {
    //     return $this->render('admin/admin_news/index.html.twig', [
    //         'controller_name' => 'AdminNewsController',
    //     ]);
    // }
}
