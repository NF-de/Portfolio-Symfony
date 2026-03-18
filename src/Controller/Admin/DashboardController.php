<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\Competences;
use App\Entity\Experiences;
use App\Entity\Formations;
use App\Entity\Projets;
use App\Entity\User;
use App\Entity\VeilleTechnologique;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * La nouvelle façon de déclarer la route dans EasyAdmin 4.12+ 
 * On définit la route DIRECTEMENT sur la classe, pas sur la méthode index.
 */
#[IsGranted('ROLE_ADMIN')]
#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Notez qu'il n'y a PLUS d'attribut #[Route] ici.
     */
    public function index(): Response
    {
        $stats = [
            'users' => $this->entityManager->getRepository(User::class)->count([]),
            'articles' => $this->entityManager->getRepository(Article::class)->count([]),
            'projets' => $this->entityManager->getRepository(Projets::class)->count([]),
            'commentaires' => $this->entityManager->getRepository(Commentaire::class)->count([]),
            'competences' => $this->entityManager->getRepository(Competences::class)->count([]),
            'experiences' => $this->entityManager->getRepository(Experiences::class)->count([]),
            'formations' => $this->entityManager->getRepository(Formations::class)->count([]),
            'veille' => $this->entityManager->getRepository(VeilleTechnologique::class)->count([]),
        ];

        return $this->render('admin/index.html.twig', [
            'stats' => $stats,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mon Portfolio - Administration')
            ->setFaviconPath('assets/images/favicon.svg');
    }

    public function configureMenuItems(): iterable
    {
        // On récupère le générateur d'URL une seule fois
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::linkToRoute('Voir le site public', 'fa fa-eye', 'app_acceuil');

        yield MenuItem::section('Contenu & Blog');
        
        // On utilise linkToUrl avec le générateur pour être compatible toutes versions
        yield MenuItem::linkToUrl('Articles', 'fas fa-newspaper', 
            $adminUrlGenerator->setController(ArticleCrudController::class)->setAction('index')->generateUrl());
        
        yield MenuItem::linkToUrl('Commentaires', 'fas fa-comments', 
            $adminUrlGenerator->setController(CommentaireCrudController::class)->setAction('index')->generateUrl());
        
        yield MenuItem::linkToUrl('Veille Technologique', 'fas fa-microchip', 
            $adminUrlGenerator->setController(VeilleTechnologiqueCrudController::class)->setAction('index')->generateUrl());

        yield MenuItem::section('Réalisations');
        yield MenuItem::linkToUrl('Projets', 'fas fa-project-diagram', 
            $adminUrlGenerator->setController(ProjetsCrudController::class)->setAction('index')->generateUrl());

        yield MenuItem::section('Mon Parcours (CV)');
        yield MenuItem::linkToUrl('Compétences', 'fas fa-chart-line', 
            $adminUrlGenerator->setController(CompetencesCrudController::class)->setAction('index')->generateUrl());
        
        yield MenuItem::linkToUrl('Expériences', 'fas fa-briefcase', 
            $adminUrlGenerator->setController(ExperiencesCrudController::class)->setAction('index')->generateUrl());
        
        yield MenuItem::linkToUrl('Formations', 'fas fa-graduation-cap', 
            $adminUrlGenerator->setController(FormationsCrudController::class)->setAction('index')->generateUrl());

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Paramètres Système');
            yield MenuItem::linkToUrl('Utilisateurs', 'fas fa-user-shield', 
                $adminUrlGenerator->setController(UserCrudController::class)->setAction('index')->generateUrl());
        }

        yield MenuItem::section();
        yield MenuItem::linkToLogout('Déconnexion', 'fas fa-sign-out-alt text-danger');
    }
}