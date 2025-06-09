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
    public function nuevo(Request $request, EntityManagerInterface $em): Response
    {

        $socio = new SocioEntity();

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
        }

        return $this->render('panel/crearSocio.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/socio/ver', name: 'socio_ver')]
    public function ver(SocioRepository $socioRepository): Response
    {
        $socio = $socioRepository->findBy(['estaActivo' => true]);

        return $this->render('panel/verSocios.html.twig', [
            'socios' => $socio,
        ]);
    }

    #[Route('/socio/detalle/{id}', name: 'socio_detalle')]
    public function verDetalle(int $id, SocioRepository $socioRepository): Response
    {

        $socio = $socioRepository->find($id);

        if (!$socio) {
            throw $this->createNotFoundException('Socio no encontrado.');
        }

        return $this->render('panel/verSocioDetalle.html.twig', [
            'socio' => $socio,
        ]);
    }

    #[Route('/socio/editar/{id}', name: 'socio_editar')]
    public function editar(int $id, Request $request, SocioRepository $socioRepository, EntityManagerInterface $em): Response
    {
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
        }

        return $this->render('panel/editarSocio.html.twig', [
            'form' => $form->createView(),
            'socio' => $socio,
        ]);
    }


    #[Route('/socio/baja/{id}', name: 'socio_baja')]
    public function baja(int $id, SocioRepository $socioRepository, EntityManagerInterface $em): Response
    {
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

