<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NewsController extends AbstractController
{
    #[Route('/news', name: 'app_news')]
    public function news(NewsRepository $repository): Response
    {
        $news = $repository->findBy(
            ['isPublished' => true],
            ['createdAt' => 'DESC'],
        );

        return $this->render('news/news.html.twig', [
            'news' => $news
        ]);
    }
}
