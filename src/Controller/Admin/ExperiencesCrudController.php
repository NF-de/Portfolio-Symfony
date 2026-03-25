<?php

namespace App\Controller\Admin;

use App\Entity\Experiences;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class ExperiencesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Experiences::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Expérience professionnelle')
            ->setEntityLabelInPlural('Expériences professionnelles')
            ->setDefaultSort(['date_debut' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('poste', 'Intitulé du poste')
                ->setHelp('Exemple: Développeur Web Fullstack'),

            TextField::new('entreprise', 'Nom de l\'entreprise'),

            ChoiceField::new('type', 'Type de contrat')
                ->setChoices([
                    'Stage' => 'Stage',
                    'Alternance' => 'Alternance',
                    'CDI' => 'CDI',
                    'CDD' => 'CDD',
                    'Freelance' => 'Freelance',
                    'Projet Personnel' => 'Projet Personnel',
                ])
                ->renderExpanded() // Affiche des boutons radio au lieu d'une liste déroulante
                ->setColumns(6),

            DateField::new('date_debut', 'Début de mission')
                ->setFormat('MMM yyyy')
                ->setColumns(3),

            DateField::new('date_fin', 'Fin de mission')
                ->setFormat('MMM yyyy')
                ->setHelp('Laisser vide si vous y êtes encore')
                ->setColumns(3),

            TextField::new('description', 'Missions et réalisations')
                ->hideOnIndex(),
        ];
    }
}