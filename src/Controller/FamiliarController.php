<?php

namespace App\Controller;

use App\Entity\CuotaEntity;
use App\Entity\FamiliarEntity;
use App\Entity\SocioEntity;
use App\Form\FamiliarType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class FamiliarController extends AbstractController
{

    #[Route('/familiar/nuevo', name: 'familiar_nuevo')]
    public function nuevo(Request                $request,
                          EntityManagerInterface $em,
                          SessionInterface       $session
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

            $numSocio = $form->get('numSocio')->getData();

            $socio = $em->getRepository(SocioEntity::class)->findOneBy(['numSocio' => $numSocio]);

            if (!$socio) {
                $this->addFlash('error', 'No se encontró ningún socio con ese número.');
            } else {
                $familiar->setSocio($socio);

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