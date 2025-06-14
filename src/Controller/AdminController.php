<?php

namespace App\Controller;

use App\Entity\AdministradorEntity;
use App\Entity\UsuarioEntity;
use App\Form\AdminType;
use App\Form\CambioPasswordType;
use App\Repository\AdministradorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    #[Route('/admin/nuevo', name: 'admin_nuevo')]
    public function nuevo(Request                $request,
                          EntityManagerInterface $em,
                          SessionInterface       $session,
    ): Response
    {

        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $usuario = $em->getRepository(UsuarioEntity::class)->find($userId);
        if (!$usuario || $usuario->getRol() !== 'ROLE_SUPERADMIN') {
            $this->addFlash('warning', 'Acceso denegado, debes tener permisos SUPER.');
            return $this->redirectToRoute('admin_panel');
        }

        $admin = new AdministradorEntity();

        $admin->setFechaCreacion(new \DateTime());
        $admin->setEstaActivo(true);

        $form = $this->createForm(AdminType::class, $admin);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $admin = $form->getData();

            $admin->setEstaActivo(true);

            $em->persist($admin);
            $em->flush();


            $this->addFlash('success', 'Gestor registrado con éxito.');
            return $this->redirectToRoute('admin_panel');
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', 'Error al registrar gestor.');
        }

        return $this->render('panel/crearAdmin.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/admin/ver', name: 'admin_ver')]
    public function ver(AdministradorRepository $administradorRepository,
                        SessionInterface        $session,
                        EntityManagerInterface  $em,
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $usuario = $em->getRepository(UsuarioEntity::class)->find($userId);
        if (!$usuario || $usuario->getRol() !== 'ROLE_SUPERADMIN') {
            $this->addFlash('warning', 'Acceso denegado, debes tener permisos de SUPER.');
            return $this->redirectToRoute('admin_panel');
        }

        $admins = $administradorRepository->findBy(['estaActivo' => true]);

        return $this->render('panel/verAdmins.html.twig', [
            'admins' => $admins,
        ]);
    }

    #[Route('/admin/detalle/{id}', name: 'admin_detalle')]
    public function verDetalle(int                     $id,
                               AdministradorRepository $administradorRepository,
                               SessionInterface        $session,
                               EntityManagerInterface  $em,
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $usuario = $em->getRepository(UsuarioEntity::class)->find($userId);
        if (!$usuario || $usuario->getRol() !== 'ROLE_SUPERADMIN') {
            $this->addFlash('warning', 'Acceso denegado, debes tener permisos de SUPER.');
            return $this->redirectToRoute('admin_panel');
        }

        $admin = $administradorRepository->find($id);

        if (!$admin) {
            throw $this->createNotFoundException('Gestor no encontrado.');
        }

        return $this->render('panel/verAdminDetalle.html.twig', [
            'admin' => $admin,
        ]);
    }

    #[Route('/admin/{id}/cambiar-rol', name: 'admin_cambiar_rol', methods: ['POST'])]
    public function cambiarRol(Request                 $request,
                               AdministradorRepository $administradorRepository,
                               EntityManagerInterface  $em,
                               int                     $id,
                               SessionInterface        $session
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $admin = $administradorRepository->find($id);
        $nuevoRol = $request->request->get('rol');

        if ($admin && $nuevoRol) {
            $admin->setRol($nuevoRol);
            $em->flush();
            $this->addFlash('success', 'Rol cambiado con éxito.');
        } else {
            $this->addFlash('error', 'Error al cambiar el rol.');
        }
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/admin/{id}/cambiar-especialidad', name: 'admin_cambiar_especialidad', methods: ['POST'])]
    public function cambiarEspecialidad(Request                 $request,
                                        AdministradorRepository $administradorRepository,
                                        EntityManagerInterface  $em,
                                        int                     $id,
                                        SessionInterface        $session
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $admin = $administradorRepository->find($id);
        $nuevaEspe = $request->request->get('especialidad');

        if ($admin && $nuevaEspe) {
            $admin->setEspecialidad($nuevaEspe);
            $em->flush();
            $this->addFlash('success', 'Especialidad cambiada con éxito.');
        } else {
            $this->addFlash('error', 'Error al cambiar especialidad.');
        }
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/admin/editar/{id}', name: 'admin_editar')]
    public function editar(
        int                     $id,
        Request                 $request,
        AdministradorRepository $adminRepo,
        EntityManagerInterface  $em,
        SessionInterface        $session
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $admin = $adminRepo->find($id);

        if (!$admin) {
            throw $this->createNotFoundException('Gestor no encontrado.');
        }

        $form = $this->createForm(AdminType::class, $admin, [
            'mostrar_rol' => false,
            'mostrar_fecha_creacion' => false,
            'mostrar_password' => false,
        ]);

        $formPassword = $this->createForm(CambioPasswordType::class);

        $form->handleRequest($request);
        $formPassword->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Datos del gestor actualizados correctamente.');
            return $this->redirectToRoute('admin_panel');
        }

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            $oldPassword = $formPassword->get('old_password')->getData();
            $newPassword = $formPassword->get('new_password')->getData();


            if ($oldPassword === $admin->getPassword()) {
                $admin->setPassword($newPassword);
                $em->flush();
                $this->addFlash('success', 'Contraseña actualizada correctamente.');
                return $this->redirectToRoute('admin_panel');
            } else {
                $this->addFlash('error', 'La contraseña actual no es correcta.');
            }
        }

        return $this->render('panel/editarAdmin.html.twig', [
            'form' => $form->createView(),
            'formPassword' => $formPassword->createView(),
            'admin' => $admin,
        ]);
    }


    #[Route('/admin/baja/{id}', name: 'admin_baja')]
    public function baja(int                     $id,
                         AdministradorRepository $adminRepository,
                         EntityManagerInterface  $em,
                         SessionInterface        $session,
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $admin = $adminRepository->find($id);

        if (!$admin) {
            throw $this->createNotFoundException('Gestor no encontrado.');
        }

        $admin->setEstaActivo(false);
        $em->flush();

        $this->addFlash('success', 'El gestor ha sido dado de baja correctamente.');

        return $this->redirectToRoute('admin_ver');
    }
}

