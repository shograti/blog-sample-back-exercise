<?php

namespace App\Controller;

use DateTime;
use App\Entity\Article;
use App\Form\ArticleType;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

#[Route('/dashboard/creer-article', name: 'creer_article')]
public function creerArticle(Request $request,EntityManagerInterface $manager,UserInterface $user): Response

{
    $slugify = new Slugify();
    $article = new Article();
    $form = $this->createForm(ArticleType::class,$article );
    $form->handleRequest($request);
    if($form->isSubmitted()&& $form->isValid()){
        $article->setSlug($slugify->slugify($article->getTitre()));
        $article->setDateCreation(new DateTime());
        $article->setIdUtilisateur($user);
        $manager->persist($article);
        $manager->flush();
        return $this->redirectToRoute('dashboard');
    
    }
    return $this->render('dashboard/creer-article.html.twig', [
        'controller_name' => 'DashboardController',
        'form' => $form->createView(),
        
    ]);
}

/* public function new(Request $request): Response
{
    $task = new Task();
    // ...

    $form = $this->createForm(TaskType::class, $task);

    return $this->renderForm('task/new.html.twig', [
        'form' => $form,
    ]);
} */
}

