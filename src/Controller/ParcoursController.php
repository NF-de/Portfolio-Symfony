<?php

namespace App\Controller;

use App\Entity\Experiences;
use App\Entity\Formations;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ParcoursController extends AbstractController
{
    #[Route('/parcours', name: 'app_parcours')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $experiences = $doctrine->getRepository(Experiences::class)
            ->findBy([], ['date_debut' => 'DESC']);

        $formations = $doctrine->getRepository(Formations::class)
            ->findBy([], ['date_debut' => 'DESC']);

        return $this->render('parcours/index.html.twig', [
            'controller_name' => 'ParcoursController',
            'experiences' => $experiences,
            'formations' => $formations,
        ]);
    }
}
