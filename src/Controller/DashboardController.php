<?php

namespace App\Controller;

use DateTime;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\ArticleType;
use Cocur\Slugify\Slugify;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(ArticleRepository $repo_article): Response
    {
        $articles = $repo_article->findAll();
        $utilisateur = $this->getUser();
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'articles' => $articles,
            "user" => $utilisateur
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


#[Route('/dashboard/modifier-article={id}+{slug}', name: 'modifier_article')]
public function modifierArticle(Request $request,EntityManagerInterface $manager,UserInterface $user, ArticleRepository $articleRepository, $id, $slug): Response

{
    $slugify = new Slugify();
    $article = $articleRepository->find($id);

    $form = $this->createFormBuilder($article)
    ->add('titre', TextType::class)
    ->add('img', TextType::class)
    ->add('contenu', TextareaType::class,['attr' => ['rows' => 15,]])
    ->add('idCategorie', EntityType::class,['class'=>Categorie::class, 'choice_label'=>'libelle_categorie', 'multiple' => true, 'expanded'=>true])
    ->add('save', SubmitType::class, ['label' => 'Modifier Article'])
    ->getForm();


    $form->handleRequest($request);
    if($form->isSubmitted()&& $form->isValid()){
        $article->setSlug($slugify->slugify($article->getTitre()));
        $article->setDateCreation(new DateTime());
        $article->setIdUtilisateur($user);
        $manager->persist($article);
        $manager->flush();
        return $this->redirectToRoute('dashboard');
    
    }
    return $this->render('dashboard/modifier-article.html.twig', [
        'controller_name' => 'ModifyController',
        'form' => $form->createView(),
        'article'=>$article
        
    ]);
}

#[Route('/dashboard/supprimer-article={id}+{slug}', name: 'supprimer_article')]
public function supprimerArticle(Request $request,EntityManagerInterface $manager,UserInterface $user, ArticleRepository $articleRepository, $id, $slug): Response

{
    $article = $articleRepository->find($id);
    $manager->remove($article);
    $manager->flush();


    return $this->render('dashboard/supprimer-article.html.twig', [
        'controller_name' => 'DeleteController'
        
        
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

