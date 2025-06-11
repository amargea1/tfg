<?php

namespace App\Controller;

use App\Entity\CuotaEntity;
use App\Entity\ReclamacionEntity;
use App\Entity\SocioEntity;
use App\Entity\UsuarioEntity;
use App\Form\ReclamacionType;
use App\Form\SocioType;
use App\Repository\ConsultaRepository;
use App\Repository\ReclamacionRepository;
use App\Repository\SocioRepository;
use App\Repository\UsuarioEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SocioController extends AbstractController
{

    #[Route('/socio/nuevo', name: 'socio_nuevo')]
    public function nuevo(Request $request,
                          EntityManagerInterface $em,
                          SocioRepository $socioRepository,
                          SessionInterface $session,
    ): Response
    {

        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $socio = new SocioEntity();

        $contador= $socioRepository->contarSociosHoy();
        $orden = $contador + 1;
        $fecha = (new \DateTime())->format('Ymd');
        $numero = str_pad((string) $orden, 4, '0', STR_PAD_LEFT);
        $socio->setNumSocio($fecha . '-' . $numero);

        $socio->setOrdenRegistro($orden);
        $socio->setFechaRegistro(new \DateTime());

        $form = $this->createForm(SocioType::class, $socio);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $socio = $form->getData();

            $cuotaRepository = $em->getRepository(CuotaEntity::class);
            $cuotaSocio = $cuotaRepository->find(1); // ← ID de la cuota estándar
            $socio->setCuota($cuotaSocio);

            $socio->setEstaActivo(true);

            $em->persist($socio);
            $em->flush();


            $this->addFlash('success', 'Socio registrado con éxito.');
            return $this->redirectToRoute('admin_panel');
        } else{
            $this->addFlash('error', 'Error al registrar socio.');
        }

        return $this->render('panel/crearSocio.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/socio/ver', name: 'socio_ver')]
    public function ver(SocioRepository $socioRepository, SessionInterface $session): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $socio = $socioRepository->findBy(['estaActivo' => true]);

        return $this->render('panel/verSocios.html.twig', [
            'socios' => $socio,
        ]);
    }

    #[Route('/socio/detalle/{id}', name: 'socio_detalle')]
    public function verDetalle(int $id, SocioRepository $socioRepository, SessionInterface $session): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $socio = $socioRepository->find($id);

        if (!$socio) {
            throw $this->createNotFoundException('Socio no encontrado.');
        }

        return $this->render('panel/verSocioDetalle.html.twig', [
            'socio' => $socio,
        ]);
    }

    #[Route('/socio/editar/{id}', name: 'socio_editar')]
    public function editar(int $id,
                           Request $request,
                           SocioRepository $socioRepository,
                           EntityManagerInterface $em,
                           SessionInterface $session,
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $socio = $socioRepository->find($id);

        if (!$socio) {
            throw $this->createNotFoundException('Socio no encontrado.');
        }

        $form = $this->createForm(SocioType::class, $socio);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Socio actualizado con éxito.');
            return $this->redirectToRoute('socio_detalle', ['id' => $socio->getId()]);
        } else{
            $this->addFlash('error', 'Error al actualizar socio.');
        }

        return $this->render('panel/editarSocio.html.twig', [
            'form' => $form->createView(),
            'socio' => $socio,
        ]);
    }


    #[Route('/socio/baja/{id}', name: 'socio_baja')]
    public function baja(int $id,
                         SocioRepository $socioRepository,
                         EntityManagerInterface $em,
                         SessionInterface $session,
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $socio = $socioRepository->find($id);

        if (!$socio) {
            throw $this->createNotFoundException('Socio no encontrado.');
        }

        $socio->setEstaActivo(false);
        $em->flush();

        $this->addFlash('success', 'El socio ha sido dado de baja correctamente.');

        return $this->redirectToRoute('socio_ver');
    }


}

