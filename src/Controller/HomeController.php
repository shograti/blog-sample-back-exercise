<?php

namespace App\Controller;


use App\Repository\ArticleRepository;

use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]

    
    
    public function index(ArticleRepository $repo_article, UtilisateurRepository $repo_utilisateur): Response
    {
        
        $utilisateurs =$repo_utilisateur->findAll();

        $articles = $repo_article->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'articles' => $articles,
            'utilisateurs'=>$utilisateurs
            
            
        ]);
    }
}
