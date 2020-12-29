<?php

namespace App\Controller\Admin;

use App\Entity\Creation;
use App\Form\AdminCreationType;
use App\Repository\CreationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/creation", name="admin_creation_")
 */
class AdminCreationController extends AbstractController
{
    /**
     * @Route("/list", name="list", methods={"GET"})
     * @param CreationRepository $creationRepository
     * @return Response
     */
    public function index(CreationRepository $creationRepository): Response
    {
        return $this->render('admin/creation/list.html.twig', [
            'creations' => $creationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $creation = new Creation();
        $form = $this->createForm(AdminCreationType::class, $creation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($creation);
            $entityManager->flush();

            return $this->redirectToRoute('admin_creation_list');
        }

        return $this->render('admin/creation/new.html.twig', [
            'creation' => $creation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Creation $creation
     * @return Response
     */
    public function show(Creation $creation): Response
    {
        return $this->render('admin/creation/show.html.twig', [
            'creation' => $creation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Creation $creation
     * @return Response
     */
    public function edit(Request $request, Creation $creation): Response
    {
        $form = $this->createForm(AdminCreationType::class, $creation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_creation_list');
        }

        return $this->render('admin/creation/edit.html.twig', [
            'creation' => $creation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Creation $creation
     * @return Response
     */
    public function delete(Request $request, Creation $creation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$creation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($creation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_creation_list');
    }
}
