<?php

namespace App\Controller;

use App\Entity\AdministradorEntity;
use App\Entity\UsuarioEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(
        Request                $request,
        EntityManagerInterface $em,
        SessionInterface       $session
    ): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');


            $usuario = $em->getRepository(UsuarioEntity::class)->findOneBy(['email' => $email]);

            if ($usuario) {
                $admin = $em->getRepository(AdministradorEntity::class)->findOneBy(['email' => $email]);

                if ($admin && $admin->getPassword() === $password) {

                    $usuario->setFechaUltimoAcceso(new \DateTimeImmutable());
                    $em->flush();

                    //Guardar datos en sesión
                    $session->set('user_id', $usuario->getId());
                    $session->set('user_email', $usuario->getEmail());
                    $session->set('user_nombre', $usuario->getNombre());
                    $session->set('user_rol', $admin->getRol());

                    return $this->redirectToRoute('admin_panel');

                } else {
                    $this->addFlash('error', 'Contraseña incorrecta.');
                }
            } else {
                $this->addFlash('error', 'Correo electrónico no encontrado.');
            }
        }
        return $this->render('index/login.html.twig');
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(SessionInterface $session): Response
    {
        $session->invalidate();
        return $this->redirectToRoute('app_login');
    }
}