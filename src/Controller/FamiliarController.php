<?php

namespace App\Controller;

use App\Entity\CuotaEntity;
use App\Entity\FamiliarEntity;
use App\Entity\ReclamacionEntity;
use App\Entity\SocioEntity;
use App\Entity\UsuarioEntity;
use App\Form\FamiliarType;
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

class FamiliarController extends AbstractController
{

    #[Route('/familiar/nuevo', name: 'familiar_nuevo')]
    public function nuevo(Request $request,
                          EntityManagerInterface $em,
                          SessionInterface $session
    ): Response
    {
        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->redirectToRoute('app_login');
        }

        $familiar = new FamiliarEntity();

        $form = $this->createForm(FamiliarType::class, $familiar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $familiar = $form->getData();

            // Obtenemos el número de socio introducido manualmente
            $numSocio = $form->get('numSocio')->getData();

            // Buscamos el socio por su número
            $socio = $em->getRepository(SocioEntity::class)->findOneBy(['numSocio' => $numSocio]);

            if (!$socio) {
                $this->addFlash('error', 'No se encontró ningún socio con ese número.');
            } else {
                // Asignamos el socio encontrado al familiar
                $familiar->setSocio($socio);

                // Asignamos la cuota para familiares (id 2)
                $cuotaFamiliar = $em->getRepository(CuotaEntity::class)->find(2);
                $familiar->setCuota($cuotaFamiliar);

                $familiar->setEstaActivo(true);


                $em->persist($familiar);
                $em->flush();

                $this->addFlash('success', 'Familiar registrado con éxito.');
                return $this->redirectToRoute('admin_panel');
            }
        }

        return $this->render('panel/crearFamiliar.html.twig', [
            'form' => $form->createView(),
        ]);
    }



}