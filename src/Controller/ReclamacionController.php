<?php

namespace App\Controller;

use App\Entity\ConsultaEntity;
use App\Entity\ReclamacionEntity;
use App\Entity\SeguimientoEntity;
use App\Entity\SocioEntity;
use App\Entity\UsuarioEntity;
use App\Form\ReclamacionType;
use App\Repository\AdministradorRepository;
use App\Repository\ConsultaRepository;
use App\Repository\ReclamacionRepository;
use App\Repository\SeguimientoRepository;
use App\Repository\SocioRepository;
use App\Repository\UsuarioEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ReclamacionController extends AbstractController
{

    #[Route('/reclamacion/nueva', name: 'reclamacion_nueva')]
    public function nueva(Request $request, EntityManagerInterface $em, SessionInterface $session): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $reclamacion = new ReclamacionEntity();
        $reclamacion->setEstado('Pendiente');

        $form = $this->createForm(ReclamacionType::class, $reclamacion);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reclamacion = $form->getData();
            $numeroSocio = $form->get('numeroSocio')->getData();

            $socio = $em->getRepository(SocioEntity::class)->findOneBy(['numSocio' => $numeroSocio]);

            if (!$socio) {
                $this->addFlash('error', 'Número de socio no válido');
                // Volver a mostrar el formulario con mensaje
                return $this->render('panel/crearReclamacion.html.twig', [
                    'form' => $form->createView()
                ]);
            }

            $esFamiliar = $form->get('esFamiliar')->getData();
            $reclamacion->setEsFamiliar($esFamiliar);

            $reclamacion->setSocio($socio);
            $reclamacion->setNumeroSocio($socio->getNumSocio());


            $reclamacion->setSocio($socio);

            $em->persist($reclamacion);
            $em->flush();


            $this->addFlash('success', 'Reclamación registrada con éxito.');
            return $this->redirectToRoute('admin_panel');
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', 'Error al registrar la reclamación.');
        }


        return $this->render('panel/crearReclamacion.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/reclamacion/ver', name: 'reclamacion_ver')]
    public function ver(Request $request, ReclamacionRepository $reclamacionRepository, SessionInterface $session): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $estado = $request->query->get('estado');
        $prioridad = $request->query->get('prioridad');

        if ($estado || $prioridad) {
            $reclamaciones = $reclamacionRepository->findByEstadoAndPrioridadWithFamiliar($estado, $prioridad);
        } else {
            $reclamaciones = $reclamacionRepository->findAllWithFamiliar();
        }

        return $this->render('panel/verReclamacion.html.twig', [
            'reclamaciones' => $reclamaciones,
        ]);
    }

    #[Route('/admin/reclamacion/{id}', name: 'reclamacion_detalle')]
    public function verDetalle(int $id,
                               ReclamacionRepository $reclamacionRepository,
                               AdministradorRepository $adminRepo,
                               SessionInterface $session
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }


        $reclamacion = $reclamacionRepository->find($id);
        $admins = $adminRepo->findAll();

        if (!$reclamacion) {
            throw $this->createNotFoundException('Reclamación no encontrada.');
        }

        return $this->render('panel/verReclamacionDetalle.html.twig', [
            'reclamacion' => $reclamacion,
            'admins' => $admins,
        ]);
    }

//    #[Route('/reclamacion/{id}/cambiar-estado', name: 'reclamacion_cambiar_estado', methods: ['POST'])]
//    public function cambiarEstado(Request $request,
//                                  ReclamacionRepository $repo,
//                                  EntityManagerInterface $em,
//                                  int $id,
//                                  SessionInterface $session
//    ): Response
//    {
//        $userId = $session->get('user_id');
//        if (!$userId) {
//            return $this->redirectToRoute('app_login');
//        }
//
//        $reclamacion = $repo->find($id);
//        $nuevoEstado = $request->request->get('estado');
//
//        if ($reclamacion && $nuevoEstado) {
//            $reclamacion->setEstado($nuevoEstado);
//            $em->flush();
//            $this->addFlash('success', 'Estado cambiado con éxito.');
//
//            if ($nuevoEstado == 'Resuelta'){
//                $reclamacion->setFechaCierre(new \DateTimeImmutable('now'));
//                $em->flush();
//            }
//        } else{
//            $this->addFlash('error', 'Error al cambiar el estado.');
//        }
//        return $this->redirect($request->headers->get('referer'));
//    }

    #[Route('/reclamacion/{id}/cambiar-prioridad', name: 'reclamacion_cambiar_prioridad', methods: ['POST'])]
    public function cambiarPrioridad(
        Request $request,
        ReclamacionRepository $repo,
        AdministradorRepository $adminRepo,
        EntityManagerInterface $em,
        int $id,
        SessionInterface $session
    ): Response {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $reclamacion = $repo->find($id);
        $nuevaPrioridad = $request->request->get('prioridad');
        $adminActual = $adminRepo->find($userId);

        if ($reclamacion && $nuevaPrioridad && $adminActual) {
            $reclamacion->setPrioridad($nuevaPrioridad);

            $seguimiento = new SeguimientoEntity();
            $seguimiento->setFecha(new \DateTimeImmutable());
            $seguimiento->setComentario("Prioridad cambiada a: " . $nuevaPrioridad);
            $seguimiento->setAdmin($adminActual);
            $seguimiento->setReclamacion($reclamacion);

            $em->persist($seguimiento);
            $em->flush();

            $this->addFlash('success', 'Prioridad cambiada con éxito.');
        } else {
            $this->addFlash('error', 'Error al cambiar la prioridad.');
        }

        return $this->redirect($request->headers->get('referer'));
    }


    #[Route('/reclamacion/{id}/cambiar-asignacion', name: 'reclamacion_cambiar_asignacion', methods: ['POST'])]
    public function cambiarAsignacion(
        Request $request,
        ReclamacionRepository $repo,
        AdministradorRepository $adminRepo,
        EntityManagerInterface $em,
        SeguimientoRepository $seguimientoRepository,
        int $id,
        SessionInterface $session
    ): Response {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $reclamacion = $repo->find($id);
        $nuevoAdminId = $request->request->get('admins'); // nombre del select
        $adminActual = $adminRepo->find($userId);

        if ($reclamacion) {
            // Quitar todos los admins actuales
            foreach ($reclamacion->getAdmins() as $adminAsignado) {
                $reclamacion->removeAdmin($adminAsignado);
            }

            $seguimiento = new SeguimientoEntity();
            $seguimiento->setFecha(new \DateTimeImmutable());
            $seguimiento->setAdmin($adminActual);
            $seguimiento->setReclamacion($reclamacion);

            if ($nuevoAdminId) {
                $nuevoAdmin = $adminRepo->find($nuevoAdminId);
                if ($nuevoAdmin) {
                    $reclamacion->addAdmin($nuevoAdmin);
                    $reclamacion->setEstado('Asignada');

                    $seguimiento->setComentario("Asignado a " . $nuevoAdmin->getNombre() . " " . $nuevoAdmin->getApellidos());
                    $this->addFlash('success', 'Administrador asignado correctamente.');
                } else {
                    $seguimiento->setComentario("Intento de asignación fallido: administrador no encontrado.");
                    $this->addFlash('error', 'Administrador no válido.');
                }
            } else {
                $reclamacion->setEstado('Sin asignar');
                $seguimiento->setComentario("Reclamación desasignada.");
                $this->addFlash('success', 'Asignación eliminada. Reclamación sin asignar.');
            }

            $em->persist($seguimiento);
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }


    #[Route('/reclamacion/{id}/nuevo-estado', name: 'reclamacion_nuevo_estado', methods: ['POST'])]
    public function nuevoEstado(
        Request $request,
        ReclamacionRepository $repo,
        EntityManagerInterface $em,
        int $id,
        SessionInterface $session
    ): Response {

        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $reclamacion = $repo->find($id);
        $fecha = $request->request->get('fecha');
        $comentario = $request->request->get('comentario');

        if ($reclamacion && $fecha && $comentario) {
            $seguimiento = new SeguimientoEntity();
            $seguimiento->setFecha(new \DateTimeImmutable($fecha));
            $seguimiento->setComentario($comentario);
            $seguimiento->setReclamacion($reclamacion);

            $em->persist($seguimiento);
            $em->flush();
            $this->addFlash('success', 'Seguimiento guardado con éxito.');
        } else{
            $this->addFlash('error', 'Error al guardar el seguimiento.');
        }

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/seguimiento/{id}/eliminar', name: 'seguimiento_eliminar', methods: ['POST'])]
    public function eliminar(
        int $id,
        SeguimientoRepository $repo,
        EntityManagerInterface $em,
        Request $request,
        SessionInterface $session
    ): Response {

        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }
        $seguimiento = $repo->find($id);

        if ($seguimiento) {
            $em->remove($seguimiento);
            $em->flush();
            $this->addFlash('success', 'Seguimiento eliminado con éxito.');
        } else {
            $this->addFlash('error', 'Error al eliminar el seguimiento.');
        }

        return $this->redirect($request->headers->get('referer')); // Vuelve a la página anterior
    }

    #[Route('/reclamacion/{id}/cerrar', name: 'reclamacion_cerrar', methods: ['POST'])]
    public function cerrarReclamacion(
        int $id,
        ReclamacionRepository $repo,
        AdministradorRepository $adminRepo,
        EntityManagerInterface $em,
        Request $request,
        SessionInterface $session
    ): Response {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $reclamacion = $repo->find($id);
        $adminActual = $adminRepo->find($userId);

        if ($reclamacion && $reclamacion->getEstado() !== 'Resuelta' && $adminActual) {
            $reclamacion->setEstado('Resuelta');
            $reclamacion->setFechaCierre(new \DateTimeImmutable());

            // Crear entrada de seguimiento
            $seguimiento = new SeguimientoEntity();
            $seguimiento->setFecha(new \DateTimeImmutable());
            $seguimiento->setComentario("Reclamación cerrada. Estado cambiado a 'Resuelta'.");
            $seguimiento->setAdmin($adminActual);
            $seguimiento->setReclamacion($reclamacion);

            $em->persist($seguimiento);
            $em->flush();

            $this->addFlash('success', 'Reclamación cerrada con éxito.');
        } else {
            $this->addFlash('error', 'Error al cerrar la reclamación.');
        }

        return $this->redirect($request->headers->get('referer'));
    }






}