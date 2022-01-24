<?php

namespace App\Controller;

use DateTime;
use App\Entity\Utilisateur;

use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Cocur\Slugify\Slugify;


class AuthController extends AbstractController{

    
    #[Route('/auth/login', name: 'login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('auth/index.html.twig',[

            'last_username' => $lastUsername,
            'error'=>$error,

        ]);
    }
    #[Route('/auth/register', name: 'register')]
    public function creerUtilisateur(Request $request,EntityManagerInterface $manager,UserPasswordHasherInterface $passwordHasher): Response
    
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class,$utilisateur);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            
            $hashedPassword = $passwordHasher->hashPassword(
                $utilisateur,
                $utilisateur->getMdp()
            );
            $utilisateur->setPassword($hashedPassword);
            
            $utilisateur->setMdp($hashedPassword);
           

            $utilisateur->setDateInscription(new DateTime());
            $utilisateur->setIpInscription($_SERVER['REMOTE_ADDR']);
            $utilisateur->setTracker($_SERVER['HTTP_USER_AGENT']);
            $utilisateur->setRoleUser('ROLE_USER');
            $manager->persist($utilisateur);
            $manager->flush();
            return $this->redirectToRoute('login');
        }
        
         
         
        return $this->render('auth/register.html.twig', [
            'controller_name' => 'AuthController',
            'form' => $form->createView(),
            
            
        ]);
    }

        /**
     * @Route("/auth/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): void
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}