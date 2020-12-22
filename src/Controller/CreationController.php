<?php

namespace App\Controller;

use App\Repository\CreationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreationController extends AbstractController
{
    /**
     * @Route("/creation", name="app_creation")
     * @param CreationRepository $repository
     * @return Response
     */
    public function index(CreationRepository $repository)
    {
        $peintureAcryliques = $repository->findAll();

        return $this->render('creation/index.html.twig', [
            'current_menu' => 'creation',
            'peintureAcryliques' => $peintureAcryliques,
        ]);
    }
}
