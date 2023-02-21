<?php

namespace App\Controller;

use App\Entity\Don;
use App\Form\DonType;
use App\Repository\DonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DonController extends AbstractController
{
/*
    #[Route('/dons', name: 'don_index')]
    public function index(): Response
    {
        return $this->render('front/don/index.html.twig', [
            'controller_name' => 'DonController',
        ]);
    }

*/





    #[Route('/dons', name: 'don_index', methods: ['GET'])]
    public function index(DonRepository $donRepository): Response
    {
        $dons = $donRepository->findAll();

        return $this->render('front/don/index.html.twig', [
            'dons' => $dons,
        ]);
    }

    #[Route('/dons/{id}', name: 'don_show', methods: ['GET'])]
    public function show(Don $don): Response
    {
        return $this->render('front/don/show.html.twig', [
            'don' => $don,
        ]);
    }

    #[Route('/dons/new', name: 'don_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $don = new Don();
        $form = $this->createForm(DonType::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($don);
            $entityManager->flush();

            return $this->redirectToRoute('don_index');
        }

        return $this->render('front/don/new.html.twig', [
            'don' => $don,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/dons/{id}/edit', name: 'don_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Don $don): Response
    {
        $form = $this->createForm(DonType::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('don_index');
        }

        return $this->render('front/don/edit.html.twig', [
            'don' => $don,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/dons/{id}', name: 'don_delete', methods: ['POST'])]
    public function delete(Request $request, Don $don): Response
    {
        if ($this->isCsrfTokenValid('delete'.$don->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($don);
            $entityManager->flush();
        }

        return $this->redirectToRoute('don_index');
    }
}
