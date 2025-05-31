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

            $em->persist($socio);
            $em->flush();


            $this->addFlash('success', 'Socio registrado con éxito.');
            return $this->redirectToRoute('admin_panel');
        }

        return $this->render('panel/crearSocio.html.twig', [
            'form' => $form->createView()
        ]);
    }


}