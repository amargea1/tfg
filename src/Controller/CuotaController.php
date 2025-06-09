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
    public function ver(CuotaRepository $cuotaRepository): Response
    {
        $cuota = $cuotaRepository->findAll();

        return $this->render('panel/verCuotas.html.twig', [
            'cuotas' => $cuota,
        ]);
    }



    #[Route('/cuota/editar/{id}', name: 'cuota_editar')]
    public function editar(int $id, Request $request, CuotaRepository $cuotaRepo, EntityManagerInterface $em): Response
    {
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
        }

        return $this->render('panel/editarCuota.html.twig', [
            'form' => $form->createView(),
            'cuota' => $cuota,
        ]);
    }

    #[Route('/cuota/nueva', name: 'cuota_nueva')]
    public function nuevo(Request $request, EntityManagerInterface $em): Response
    {

        $cuota = new CuotaEntity();

        $form = $this->createForm(CuotaType::class, $cuota);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cuota = $form->getData();

            $em->persist($cuota);
            $em->flush();


            $this->addFlash('success', 'Cuota registrada con éxito.');
            return $this->redirectToRoute('cuota_ver');
        }

        return $this->render('panel/crearCuota.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/cuota/borrar/{id}', name: 'cuota_borrar')]
    public function baja(int $id, CuotaRepository $cuotaRepository, EntityManagerInterface $em): Response
    {
        $cuota = $cuotaRepository->find($id);

        if (!$cuota) {
            throw $this->createNotFoundException('Cuota no encontrada.');
        }

        $em->remove($cuota);
        $em->flush();

        $this->addFlash('success', 'La cuota ha sido dada de baja correctamente.');

        return $this->redirectToRoute('cuota_ver');
    }

}

