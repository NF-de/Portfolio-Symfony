<?php

namespace App\Controller;

use App\Entity\Projets;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

final class RealisationsController extends AbstractController
{
    #[Route('/realisations', name: 'app_realisations')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $projets = $doctrine->getRepository(Projets::class)
            ->findBy([], ['date_creation' => 'DESC']);

        $projetsParType = [];
        foreach ($projets as $projet) {
            $type = $projet->getType() ?? 'autre';
            if (!isset($projetsParType[$type])) {
                $projetsParType[$type] = [];
            }
            $projetsParType[$type][] = $projet;
        }

        return $this->render('realisations/index.html.twig', [
            'projetsParType' => $projetsParType,
        ]);
    }
}
