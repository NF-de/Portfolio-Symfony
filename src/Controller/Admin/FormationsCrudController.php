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
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

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

                $pdfUploadDir = 'public/uploads/projets';
        $pdfBasePath = 'uploads/projets';
        
        return [
            
            TextField::new('titre', 'Diplôme / Formation'),
            
            TextField::new('etablissement', 'École / Centre'),
            
            TextField::new('ville', 'Ville'),

            TextField::new('description', 'Détails de la formation')
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
                ->setRequired(false),

                Field::new('rapportPdf', 'Formation (PDF)')
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
        ];
    }
}