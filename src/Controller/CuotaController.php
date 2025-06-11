<?php

namespace App\Controller;


use App\Entity\CuotaEntity;
use App\Form\CuotaType;

use App\Repository\CuotaRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class CuotaController extends AbstractController
{

    #[Route('/cuota/ver', name: 'cuota_ver')]
    public function ver(CuotaRepository $cuotaRepository, SessionInterface $session): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $cuota = $cuotaRepository->findAll();

        return $this->render('panel/verCuotas.html.twig', [
            'cuotas' => $cuota,
        ]);
    }



    #[Route('/cuota/editar/{id}', name: 'cuota_editar')]
    public function editar(int $id,
                           Request $request,
                           CuotaRepository $cuotaRepo,
                           EntityManagerInterface $em,
                           SessionInterface $session,

    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $cuota = $cuotaRepo->find($id);

        if (!$cuota) {
            throw $this->createNotFoundException('Cuota no encontrada.');
        }

        $form = $this->createForm(CuotaType::class, $cuota);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Cuota actualizada con éxito.');
            return $this->redirectToRoute('cuota_ver');
        } else {
            this->addFlash('error', 'Error al actualizar la cuota.');
        }

        return $this->render('panel/editarCuota.html.twig', [
            'form' => $form->createView(),
            'cuota' => $cuota,
        ]);
    }

    #[Route('/cuota/nueva', name: 'cuota_nueva')]
    public function nuevo(Request $request,
                          EntityManagerInterface $em,
                          SessionInterface $session,

    ): Response
    {

        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $cuota = new CuotaEntity();

        $form = $this->createForm(CuotaType::class, $cuota);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cuota = $form->getData();

            $em->persist($cuota);
            $em->flush();
            $this->addFlash('success', 'Cuota registrada con éxito.');
            return $this->redirectToRoute('cuota_ver');
        } else {
            $this->addFlash('error', 'Error al registrar la cuota.');
        }

        return $this->render('panel/crearCuota.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/cuota/borrar/{id}', name: 'cuota_borrar')]
    public function baja(int $id,
                         CuotaRepository $cuotaRepository,
                         EntityManagerInterface $em,
                         SessionInterface $session
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $cuota = $cuotaRepository->find($id);

        if (!$cuota) {
            throw $this->createNotFoundException('Cuota no encontrada.');
        }

        if (count($cuota->getSocios()) > 0 || count($cuota->getFamiliares()) > 0) {
            $this->addFlash('error', 'No puedes eliminar una cuota asignada a socios o familiares.');
            return $this->redirectToRoute('cuota_ver');
        }

        $em->remove($cuota);
        $em->flush();

        $this->addFlash('success', 'La cuota ha sido dada de baja correctamente.');

        return $this->redirectToRoute('cuota_ver');
    }

}

