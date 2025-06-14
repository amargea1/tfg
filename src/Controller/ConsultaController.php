<?php

namespace App\Controller;

use App\Repository\AdministradorRepository;
use App\Repository\ConsultaRepository;
use App\Repository\FamiliarRepository;
use App\Repository\SocioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ConsultaController extends AbstractController
{

    #[Route('/consulta/ver', name: 'consultas_ver')]
    public function ver(Request            $request,
                        ConsultaRepository $consultaRepository,
                        SessionInterface   $session,

    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $consultas = $consultaRepository->findAll();
        $estado = $request->query->get('estado');
        if ($estado) {
            $consultas = $consultaRepository->findWithEstadoOrdered($estado);
        } else {
            $consultas = $consultaRepository->findAllOrderedByFechaDesc();
        }


        return $this->render('panel/verConsultas.html.twig', [
            'consultas' => $consultas,
        ]);
    }

    #[Route('/admin/consulta/{id}', name: 'consulta_detalle')]
    public function verDetalle(
        int                     $id,
        ConsultaRepository      $consultaRepository,
        AdministradorRepository $adminRepo,
        SocioRepository         $socioRepository,
        FamiliarRepository      $familiarRepository,
        SessionInterface        $session,

    ): Response
    {

        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $consulta = $consultaRepository->find($id);
        $admins = $adminRepo->findAll();

        $socio = null;
        $familiar = null;

        if ($consulta->getSocio()) {
            $socio = $socioRepository->find($consulta->getSocio()->getId());
        }

        if ($consulta->getFamiliar()) {
            $familiar = $familiarRepository->find($consulta->getFamiliar()->getId());
        }

        $tipoConsulta = null;

        if ($socio) {
            $tipoConsulta = 'Socio';
        } elseif ($familiar) {
            $tipoConsulta = 'Familiar';
        }

        if (!$consulta) {
            throw $this->createNotFoundException('Consulta no encontrada.');
        }

        return $this->render('panel/verConsultaDetalle.html.twig', [
            'consulta' => $consulta,
            'admins' => $admins,
            'tipoConsulta' => $tipoConsulta,
        ]);
    }

    #[Route('/consulta/{id}/cambiar-estado', name: 'consulta_cambiar_estado', methods: ['POST'])]
    public function cambiarEstado(Request                $request,
                                  ConsultaRepository     $repo,
                                  EntityManagerInterface $em,
                                  int                    $id,
                                  SessionInterface       $session,
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $consulta = $repo->find($id);
        $nuevoEstado = $request->request->get('estado');

        if ($nuevoEstado == 'Resuelta') {
            $consulta->setFechaCierre(new \DateTimeImmutable('now'));
        }

        if ($consulta && $nuevoEstado) {
            $consulta->setEstado($nuevoEstado);
            $em->flush();
            $this->addFlash('success', 'Estado cambiado con éxito.');
        } else {
            $this->addFlash('error', 'Error al cambiar el estado.');
        }

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/consulta/{id}/cambiar_via', name: 'consulta_cambiar_via', methods: ['POST'])]
    public function cambiarVia(Request                $request,
                               ConsultaRepository     $repo,
                               EntityManagerInterface $em,
                               int                    $id,
                               SessionInterface       $session,
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $consulta = $repo->find($id);
        $via = $request->request->get('via_respuesta');

        if ($consulta && $via) {
            $consulta->setViaRespuesta($via);
            $em->flush();
            $this->addFlash('success', 'Vía de respuesta cambiada con éxito.');
        } else {
            $this->addFlash('error', 'Error al cambiar la vía de respuesta.');
        }

        return $this->redirect($request->headers->get('referer'));
    }


    #[Route('/consulta/{id}/cerrar', name: 'consulta_cerrar', methods: ['POST'])]
    public function cerrar(
        int                    $id,
        ConsultaRepository     $repo,
        EntityManagerInterface $em,
        SessionInterface       $session,
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $consulta = $repo->find($id);

        if ($consulta && $consulta->getEstado() !== 'Resuelta') {
            $consulta->setEstado('Resuelta');
            $consulta->setFechaCierre(new \DateTimeImmutable('now'));
            $em->flush();
            $this->addFlash('success', 'Consulta cerrada con éxito.');
        } else {
            $this->addFlash('error', 'Error al cerrar la consulta.');
        }

        return $this->redirectToRoute('consultas_ver');
    }

}