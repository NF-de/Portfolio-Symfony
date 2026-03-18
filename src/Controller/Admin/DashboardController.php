<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\Competences;
use App\Entity\Experiences;
use App\Entity\Formations;
use App\Entity\Log;
use App\Entity\Projets;
use App\Entity\User;
use App\Entity\VeilleTechnologique;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use App\Controller\Admin\ArticleCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Controller\Admin\CommentaireCrudController;
use App\Controller\Admin\VeilleTechnologiqueCrudController;
use App\Controller\Admin\ProjetsCrudController;
use App\Controller\Admin\CompetencesCrudController;
use App\Controller\Admin\ExperiencesCrudController;
use App\Controller\Admin\FormationsCrudController;
use App\Controller\Admin\UserCrudController;
#[IsGranted('ROLE_ADMIN')]
#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function index(): Response
    {
        $stats = [
            'users' => $this->entityManager->getRepository(User::class)->count([]),
            'articles' => $this->entityManager->getRepository(Article::class)->count([]),
            'projets' => $this->entityManager->getRepository(Projets::class)->count([]),
            'commentaires' => $this->entityManager->getRepository(Commentaire::class)->count([]),
            // On ajoute le reste ici :
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
        if ($this->isGranted('ROLE_ADMIN')) {
            $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

            // Tableau de bord
            yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');

            // Voir le site public
            yield MenuItem::linkToRoute('Voir le site public', 'fa fa-eye', 'app_acceuil');

            // Section Contenu & Blog
            yield MenuItem::section('Contenu & Blog');

            yield MenuItem::linkToUrl(
                'Articles',
                'fas fa-newspaper',
                $adminUrlGenerator
                    ->setController(ArticleCrudController::class)
                    ->setAction('index')
                    ->generateUrl()
            );

            yield MenuItem::linkToUrl(
                'Commentaires',
                'fas fa-comments',
                $adminUrlGenerator
                    ->setController(CommentaireCrudController::class)
                    ->setAction('index')
                    ->generateUrl()
            );

            yield MenuItem::linkToUrl(
                'Veille Technologique',
                'fas fa-microchip',
                $adminUrlGenerator
                    ->setController(VeilleTechnologiqueCrudController::class)
                    ->setAction('index')
                    ->generateUrl()
            );

            // Section Réalisations
            yield MenuItem::section('Réalisations');

            yield MenuItem::linkToUrl(
                'Projets',
                'fas fa-project-diagram',
                $adminUrlGenerator
                    ->setController(ProjetsCrudController::class)
                    ->setAction('index')
                    ->generateUrl()
            );

            // Section Mon Parcours (CV)
            yield MenuItem::section('Mon Parcours (CV)');

            yield MenuItem::linkToUrl(
                'Compétences',
                'fas fa-chart-line',
                $adminUrlGenerator
                    ->setController(CompetencesCrudController::class)
                    ->setAction('index')
                    ->generateUrl()
            );

            yield MenuItem::linkToUrl(
                'Expériences',
                'fas fa-briefcase',
                $adminUrlGenerator
                    ->setController(ExperiencesCrudController::class)
                    ->setAction('index')
                    ->generateUrl()
            );

            yield MenuItem::linkToUrl(
                'Formations',
                'fas fa-graduation-cap',
                $adminUrlGenerator
                    ->setController(FormationsCrudController::class)
                    ->setAction('index')
                    ->generateUrl()
            );

            // Section Paramètres Système (pour les admins)
            if ($this->isGranted('ROLE_ADMIN')) {
                yield MenuItem::section('Paramètres Système');

                yield MenuItem::linkToUrl(
                    'Utilisateurs',
                    'fas fa-user-shield',
                    $adminUrlGenerator
                        ->setController(UserCrudController::class)
                        ->setAction('index')
                        ->generateUrl()
                );
            }

            // Déconnexion
            yield MenuItem::section();
            yield MenuItem::linkToLogout('Déconnexion', 'fas fa-sign-out-alt text-danger');
        }
    }
}