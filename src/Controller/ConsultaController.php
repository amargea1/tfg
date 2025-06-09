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
use App\Repository\FamiliarRepository;
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

class ConsultaController extends AbstractController
{

    #[Route('/consulta/ver', name: 'consultas_ver')]
    public function ver(ConsultaRepository $consultaRepository,
                        SessionInterface $session,
    ): Response
    {

        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $consultas = $consultaRepository->findAll();


        return $this->render('panel/verConsultas.html.twig', [
            'consultas' => $consultas,
        ]);
    }

    #[Route('/admin/consulta/{id}', name: 'consulta_detalle')]
    public function verDetalle(
        int $id,
        ConsultaRepository $consultaRepository,
        AdministradorRepository $adminRepo,
        SocioRepository $socioRepository,
        FamiliarRepository $familiarRepository,
        SessionInterface $session,

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
    public function cambiarEstado(Request $request,
                                  ConsultaRepository $repo,
                                  EntityManagerInterface $em,
                                  int $id,
                                  SessionInterface $session,
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $consulta = $repo->find($id);
        $nuevoEstado = $request->request->get('estado');

        if($nuevoEstado == 'Resuelta'){
            $consulta->setFechaCierre(new \DateTimeImmutable('now'));
        }

        if ($consulta && $nuevoEstado) {
            $consulta->setEstado($nuevoEstado);
            $em->flush();
        }

        return $this->redirect($request->headers->get('referer'));
    }


    #[Route('/consulta/{id}/cerrar', name: 'consulta_cerrar', methods: ['POST'])]
    public function cerrar(
        int $id,
        ConsultaRepository $repo,
        EntityManagerInterface $em,
        Request $request,
        SessionInterface $session,
    ): Response {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $consulta = $repo->find($id);

        if ($consulta && $consulta->getEstado() !== 'Resuelta') {
            $consulta->setEstado('Resuelta'); // o el valor que uses para “cerrado”
            $consulta->setFechaCierre(new \DateTimeImmutable('now'));
            $em->flush();
        }

        return $this->redirectToRoute('consultas_ver');
    }





}