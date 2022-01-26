<?php

namespace App\Controller;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController {

    #[Route('/blog/{id}+{slug}', name: 'blog')]
    public function show(ArticleRepository $articleRepository, $id, $slug): Response
    {
        $article = $articleRepository->find($id);

        if ($article != Null && $article->getSlug() == $slug)
        {
            return $this->render('blog/index.html.twig', [
                    'controller_name' => 'HomeController',
                    'article' => $article
                    ]
            );
        }
        return $this->render('blog/error.html.twig');
    }
}