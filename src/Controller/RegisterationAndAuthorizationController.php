<?php

namespace App\Controller;

use DateTime;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterationAndAuthorizationController extends AbstractController {

    private $verifyEmailHelper;
    private $mailer;
    
    public function __construct(VerifyEmailHelperInterface $helper, MailerInterface $mailer)
    {
        $this->verifyEmailHelper = $helper;
        $this->mailer = $mailer;
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

                $signatureComponents = $this->verifyEmailHelper->generateSignature(
                    'registration_confirmation_route',
                    $utilisateur->getIdUtilisateur(),
                    $utilisateur->getEmail(),
                    ['id' => $utilisateur->getIdUtilisateur()]
                );
            
                $email = new TemplatedEmail();
                $email->from('send@example.com');
                $email->to($utilisateur->getEmail());
                $email->htmlTemplate('auth/confirmation_email.html.twig');
                $email->context(['signedUrl' => $signatureComponents->getSignedUrl()]);
                
                $this->mailer->send($email);
                
                return $this->redirectToRoute('login');
            }
            
        return $this->render('auth/register.html.twig', [

            'controller_name' => 'AuthController',
            'form' => $form->createView(),
            ]);
        }

        #[Route('/auth/verify', name: 'registration_confirmation_route')]

        public function verifyUserEmail(UtilisateurRepository $utilisateurRepository, Request $request,EntityManagerInterface $manager): Response
        {
            $id = $request->get('id');
            
            if (null === $id) {
                return $this->redirectToRoute('home');
            }

            $user = $utilisateurRepository->find($id);

       
            if (null === $user) {
                return $this->redirectToRoute('home');
            }
      
            try {

                $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getIdUtilisateur(), $user->getEmail());

            } catch (VerifyEmailExceptionInterface $e) {

                $this->addFlash('verify_email_error', $e->getReason());
                return $this->redirectToRoute('app_register');
             }

            $user->setIsVerified(true);
            $this->addFlash('success', 'Your e-mail address has been verified.');
            $user->setRoles(['ROLE_AUTHORIZED_USER']);
            $user->setRoleUser('ROLE_AUTHORIZED_USER');

            $manager->persist($user);
            $manager->flush();
            
            $user->getRoles();

            return $this->redirectToRoute('creer_article');
        }
}