<?php

namespace App\Controller;

use App\Entity\UsuarioEntity;
use App\Repository\ConsultaRepository;
use App\Repository\ReclamacionRepository;
use App\Repository\SocioRepository;
use App\Repository\UsuarioEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PanelController extends AbstractController
{

    #[Route('/admin/panel', name: 'admin_panel')]
    public function panel(
        SessionInterface $session,
        UsuarioEntityRepository $usuarioRepository,
        SocioRepository $socioRepository,
        ReclamacionRepository $reclamacionRepository,
        ConsultaRepository $consultaRepository,
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $nombre = $usuarioRepository->findNombreById($userId);

        if (!$nombre) {
            $this->addFlash('error', 'Usuario no encontrado.');
            return $this->redirectToRoute('app_login');
        }

        $totalSocios = $socioRepository->contarSocios();
        $recAbiertas = $reclamacionRepository->contarReclamacionesAbiertas();
        $consAbiertas = $consultaRepository->contarConsultasAbiertas();


        return $this->render('index/panel.html.twig', [
            'nombre' => $nombre,
            'total_socios' => $totalSocios,
            'rec_abiertas' => $recAbiertas,
            'cons_abiertas' => $consAbiertas,
        ]);

    }


}