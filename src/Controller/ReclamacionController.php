<?php

namespace App\Controller;

use App\Entity\ConsultaEntity;
use App\Entity\ReclamacionEntity;
use App\Entity\SocioEntity;
use App\Entity\UsuarioEntity;
use App\Form\ReclamacionType;
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

            $familiar = $reclamacion->getFamiliar();
            if ($familiar) {
                $familiar->setSocio($socio);
                $em->persist($familiar);
            }

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
    public function ver(EntityManagerInterface $em): Response
    {

        $reclamacion = $em->getRepository(ReclamacionEntity::class)->findAll();

        return $this->render('panel/verReclamacion.html.twig', [
            'reclamaciones' => $reclamacion,
        ]);
    }

}