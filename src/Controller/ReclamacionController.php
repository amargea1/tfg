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
    public function nueva(Request $request, EntityManagerInterface $em): Response
    {

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
        }

        return $this->render('panel/crearReclamacion.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/reclamacion/ver', name: 'reclamacion_ver')]
    public function ver(ReclamacionRepository $reclamacionRepository): Response
    {
        $reclamaciones = $reclamacionRepository->findAllWithFamiliar();

        return $this->render('panel/verReclamacion.html.twig', [
            'reclamaciones' => $reclamaciones,
        ]);
    }

    #[Route('/admin/reclamacion/{id}', name: 'reclamacion_detalle')]
    public function verDetalle(int $id, ReclamacionRepository $reclamacionRepository, AdministradorRepository $adminRepo): Response
    {

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

    #[Route('/reclamacion/{id}/cambiar-estado', name: 'reclamacion_cambiar_estado', methods: ['POST'])]
    public function cambiarEstado(Request $request, ReclamacionRepository $repo, EntityManagerInterface $em, int $id): Response
    {
        $reclamacion = $repo->find($id);
        $nuevoEstado = $request->request->get('estado');

        if ($reclamacion && $nuevoEstado) {
            $reclamacion->setEstado($nuevoEstado);
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/reclamacion/{id}/cambiar-asignacion', name: 'reclamacion_cambiar_asignacion', methods: ['POST'])]
    public function cambiarAsignacion(
        Request $request,
        ReclamacionRepository $repo,
        AdministradorRepository $adminRepo,
        EntityManagerInterface $em,
        int $id
    ): Response {
        $reclamacion = $repo->find($id);
        $adminId = $request->request->get('admins'); // usa 'admin' si el select es name="admin"

        if ($reclamacion && $adminId) {
            $admin = $adminRepo->find($adminId);

            if ($admin) {
                // Como es ManyToMany, limpia admins actuales y añade el nuevo admin
                foreach ($reclamacion->getAdmins () as $adminActual) {
                    $reclamacion->removeAdmin($adminActual);
                }
                $reclamacion->addAdmin($admin);
                $em->flush();
            }
        }

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/reclamacion/{id}/nuevo-estado', name: 'reclamacion_nuevo_estado', methods: ['POST'])]
    public function nuevoEstado(
        Request $request,
        ReclamacionRepository $repo,
        EntityManagerInterface $em,
        int $id
    ): Response {
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
        }

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/seguimiento/{id}/eliminar', name: 'seguimiento_eliminar', methods: ['POST'])]
    public function eliminar(
        int $id,
        SeguimientoRepository $repo,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $seguimiento = $repo->find($id);

        if ($seguimiento) {
            $em->remove($seguimiento);
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer')); // Vuelve a la página anterior
    }

    #[Route('/reclamacion/{id}/cerrar', name: 'reclamacion_cerrar', methods: ['POST'])]
    public function cerrarReclamacion(
        int $id,
        ReclamacionRepository $repo,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $reclamacion = $repo->find($id);

        if ($reclamacion && $reclamacion->getEstado() !== 'resuelta') {
            $reclamacion->setEstado('resuelta'); // o el valor que uses para “cerrado”
            $reclamacion->setFechaCierre(new \DateTimeImmutable('now'));
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }





}