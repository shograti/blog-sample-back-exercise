<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Controller\AuthController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LogoutController extends AbstractController {

    #[Route('/auth/logout', name: 'app_logout' )]

        public function logout(): void
        {
            throw new \Exception('Don\'t forget to activate logout in security.yaml');
        }
        
}