<?php

namespace App\Controller\Admin;

use App\Entity\Projets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

#[IsGranted('ROLE_ADMIN')]
class ProjetsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Projets::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Projet')
            ->setEntityLabelInPlural('Projets')
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        // Configuration pour les IMAGES
        $imgUploadDir = 'public/uploads/projets';
        $imgBasePath = 'uploads/projets';

        // Configuration pour les PDF (Rapports)
        $pdfUploadDir = 'public/uploads/projets';
        $pdfBasePath = 'uploads/projets';

        return [
            TextField::new('titre', 'Nom du projet'),
            TextField::new('description', 'Description détaillée')->hideOnIndex(),
            TextField::new('technologies', 'Technologies utilisées')
                ->setHelp('Exemple: Symfony, React, Tailwind...'),
            UrlField::new('lien_demo', 'Lien Démo'),
            UrlField::new('lien_github', 'Lien GitHub'),

            ChoiceField::new('type', 'Type de projet')
                ->setChoices([
                    'Professionnel' => 'professionnel',
                    'Cours' => 'cours',
                    'TP' => 'tp',
                ])
                ->setRequired(true),

            // Image du projet
            ImageField::new('image', 'Image du projet')
                ->setUploadDir($imgUploadDir)
                ->setBasePath($imgBasePath)
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->hideOnIndex(),

            Field::new('rapportPdf', 'Rapport de stage (PDF)')
                ->setFormType(FileUploadType::class)
                ->setFormTypeOptions([
                    'upload_dir' => $pdfUploadDir,
                    'upload_new' => function ($file, $uploadDir, $fileName) {
                        $file->move($uploadDir, $fileName);
                    },
                ])
                // Nettoyage du nom de fichier : ENLEVER LES ESPACES
                ->setCustomOption('uploadedFileNamePattern', '[slug]-[timestamp].[extension]')
                ->formatValue(function ($value, $entity) use ($pdfBasePath) {
                    if (!$value)
                        return 'Aucun PDF';
                    // On force le lien vers le bon dossier
                    return sprintf('<a href="/%s/%s" target="_blank">📄 Voir le PDF</a>', $pdfBasePath, $value);
                })
                ->setHelp('Évitez les espaces dans le nom du fichier')
                ->setHelp('Fichier PDF uniquement')
                ->hideOnIndex()
                // On définit comment le nom du fichier est généré
                ->setCustomOption('basePath', 'uploads/rapports')
                ->setCustomOption('uploadDir', 'public/uploads/rapports')
                ->setCustomOption('uploadedFileNamePattern', '[slug]-[timestamp].pdf')
                ->setHelp('Fichier PDF uniquement')
                ->hideOnIndex(), // On le cache de la liste pour éviter les erreurs d'affichage

            DateField::new('date_creation', 'Date de réalisation')
                ->hideOnForm(),

            BooleanField::new('en_vedette', 'Mettre en avant')
                ->setHelp('Si activé, le projet apparaîtra dans la section "À la une"'),
        ];
    }
}