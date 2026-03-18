<?php

namespace App\Controller\Admin;

use App\Entity\Competences;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class CompetencesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Competences::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Compétence')
            ->setEntityLabelInPlural('Compétences')
            // On trie par catégorie puis par nom par défaut
            ->setDefaultSort(['categorie' => 'ASC', 'nom' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('nom', 'Nom de la compétence')
                ->setHelp('Exemple: PHP, Symfony, Docker, Gestion de projet...'),

            // Utilisation d'un ChoiceField pour éviter de faire des fautes de frappe dans les catégories
            ChoiceField::new('categorie', 'Catégorie')
                ->setChoices([
                    'Développement Back-end' => 'Back-end',
                    'Développement Front-end' => 'Front-end',
                    'Base de données' => 'Database',
                    'Outils / DevOps' => 'DevOps',
                    'Soft Skills' => 'Soft Skills',
                ]),

            // Niveau de 0 à 100
            IntegerField::new('niveau', 'Maîtrise (0 à 100)')
                ->setHelp('Indiquez votre niveau en pourcentage')
                ->setFormTypeOptions([
                    'attr' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ]),

            TextField::new('icone', 'Icône (Classe FontAwesome)')
                ->setHelp('Exemple: fab fa-symfony, fas fa-database...')
                ->setEmptyData('fas fa-code'),
        ];
    }
}