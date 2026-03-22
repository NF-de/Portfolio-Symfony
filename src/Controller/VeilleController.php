<?php

namespace App\Controller;

use App\Entity\VeilleTechnologique;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;

final class VeilleController extends AbstractController
{
    #[Route('/veille', name: 'app_veille')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $veille = $doctrine->getRepository(VeilleTechnologique::class)
            ->findBy([], ['date_publication' => 'DESC']);

        return $this->render('veille/index.html.twig', [
            'veille' => $veille,
        ]);
    }
}
