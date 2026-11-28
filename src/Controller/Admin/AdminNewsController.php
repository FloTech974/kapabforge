<?php

namespace App\Controller\Admin;

use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\News;
use App\Form\NewsType;
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

    #[Route('/admin/news/newnews', name: 'app_admin_newnews')]
    public function newNews(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $news->setCreatedAt(new \DateTimeImmutable());
            $news->setUpdatedAt(new \DateTimeImmutable());
            $news->setSlug($slugger->slug($news->getName())->lower());
            $manager->persist($news);
            $manager->flush();
            $this->addFlash('success', 'L\'actualité a été créée avec succès.');

            return $this->redirectToRoute('app_admin_news');
        }

        return $this->render('admin/news/newnews.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/news/delete/{id}', name: 'app_admin_deletenews')]
    public function deleteNews(News $news, EntityManagerInterface $manager): Response
    {
        $manager->remove($news);
        $manager->flush();
        $this->addFlash('warning', 'L\'actualité a été supprimée avec succès.');

        return $this->redirectToRoute('app_admin_news');
    }

    #[Route('/admin/news/edit/{id}', name: 'app_admin_editnews')]
    public function editNews(News $news, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $news->setUpdatedAt(new \DateTimeImmutable());
            $news->setSlug($slugger->slug($news->getName())->lower());
            $manager->flush();
            $this->addFlash('success', 'L\'actualité a été modifiée avec succès.');

            return $this->redirectToRoute('app_admin_news');
        }

        return $this->render('admin/news/editnews.html.twig', [
            'form' => $form,
            'news' => $news,
        ]);
    }

    #[Route('/admin/news/view/{id}', name: 'app_admin_viewnews')]
    public function viewNews(News $news, EntityManagerInterface $manager): Response
    {
        $news->setIsPublished(!$news->isPublished());
        $manager->flush();
        $this->addFlash('info', $news->isPublished() ? 'L\'actualité est maintenant visible.' : 'L\'actualité est maintenant masquée.');

        return $this->redirectToRoute('app_admin_news');
    }
}
