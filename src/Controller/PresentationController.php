<?php

namespace App\Controller;

use App\Repository\CompetencesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PresentationController extends AbstractController
{
    #[Route('/presentation', name: 'app_presentation')]
    public function index(CompetencesRepository $repository): Response
    {
        // Récupérer les compétences depuis le repository
        $competences = $repository->findBy([], ['categorie' => 'ASC']);

        // Passer la variable competences à la vue
        return $this->render('presentation/index.html.twig', [
            'controller_name' => 'PresentationController',
            'competences' => $competences, // Ajout de cette ligne
        ]);
    }
}
