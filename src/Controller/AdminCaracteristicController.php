<?php

namespace App\Controller;

use App\Entity\Caracteristic;
use App\Form\CaracteristicType;
use App\Repository\CaracteristicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/caracteristic")
 */
class AdminCaracteristicController extends AbstractController
{
    /**
     * @Route("/", name="admin_caracteristic_index", methods={"GET"})
     */
    public function index(CaracteristicRepository $caracteristicRepository): Response
    {
        return $this->render('admin/caracteristic/index.html.twig', [
            'caracteristics' => $caracteristicRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_caracteristic_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $caracteristic = new Caracteristic();
        $form = $this->createForm(CaracteristicType::class, $caracteristic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($caracteristic);
            $entityManager->flush();
            $this->addFlash('success','Votre caractéristique est bien enregistrée');

            return $this->redirectToRoute('admin_caracteristic_index');
        }

        return $this->render('admin/caracteristic/new.html.twig', [
            'caracteristic' => $caracteristic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_caracteristic_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Caracteristic $caracteristic): Response
    {
        $form = $this->createForm(CaracteristicType::class, $caracteristic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Votre modification est bien enregistrée');

            return $this->redirectToRoute('admin_caracteristic_index');
        }

        return $this->render('admin/caracteristic/edit.html.twig', [
            'caracteristic' => $caracteristic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_caracteristic_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Caracteristic $caracteristic): Response
    {
        if ($this->isCsrfTokenValid('delete'.$caracteristic->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($caracteristic);
            $entityManager->flush();
            $this->addFlash('success','Votre suppréssion est bien enregistrée');
        }

        return $this->redirectToRoute('admin_caracteristic_index');
    }
}
