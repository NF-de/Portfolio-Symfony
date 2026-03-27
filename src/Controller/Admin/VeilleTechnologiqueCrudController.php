<?php

namespace App\Controller\Admin;

use App\Entity\VeilleTechnologique;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class VeilleTechnologiqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return VeilleTechnologique::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Veille Technologique')
            ->setEntityLabelInPlural('Veilles Technologiques')
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        $uploadDir = 'public/uploads/veille';
        $basePath = 'uploads/veille';

        return [
            TextField::new('titre', 'Titre de la veille'),

            TextField::new('description', 'Description / Résumé')
                ->hideOnIndex(),

            UrlField::new('url_source', 'Lien vers la source'),

            ImageField::new('image', 'Image de couverture')
                ->setUploadDir($uploadDir)
                ->setBasePath($basePath)
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->setRequired($pageName === Crud::PAGE_NEW),

            // On cache la date de l'index ET du formulaire
            // Elle sera quand même remplie par le PrePersist de ton Entité
            DateTimeField::new('date_publication'),
        ];
    }
}