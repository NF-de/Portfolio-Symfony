<?php

namespace App\Controller\Admin;

use App\Entity\Formations;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class FormationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Formations::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Formation')
            ->setEntityLabelInPlural('Formations')
            ->setDefaultSort(['date_debut' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        $uploadDir = 'public/uploads/formations';
        $basePath = 'uploads/formations';

        return [
            
            TextField::new('titre', 'Diplôme / Formation'),
            
            TextField::new('etablissement', 'École / Centre'),
            
            TextField::new('ville', 'Ville'),

            TextEditorField::new('description', 'Détails de la formation')
                ->hideOnIndex(),

            DateField::new('date_debut', 'Date de début')
                ->setFormat('MMM yyyy'),

            DateField::new('date_fin', 'Date de fin')
                ->setFormat('MMM yyyy')
                ->setHelp('Laissez vide si toujours en cours'),

            ImageField::new('image', 'Diplome/Formation')
                ->setUploadDir($uploadDir)
                ->setBasePath($basePath)
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->setRequired($pageName === Crud::PAGE_NEW),
        ];
    }
}