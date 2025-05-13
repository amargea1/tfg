<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PanelController extends AbstractController
{

    #[Route('/admin/panel', name: 'admin_panel')]
    public function panel(SessionInterface $session): Response
    {
        if (!$session->get('user_id')) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('index/panel.html.twig');
    }


}