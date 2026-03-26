<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;
#[IsGranted('ROLE_ADMIN')]
class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
{
    return [
        TextField::new('titre', 'Titre de l\'article'),
        TextField::new('contenu', 'Contenu')
            ->hideOnIndex(),
        AssociationField::new('auteur_id', 'Auteur'),

        DateTimeField::new('created_at', 'Date de création')
            ->setFormat('dd/MM/y HH:mm')
            ->hideOnForm() // <--- Cache le champ dans le formulaire de création/édition
            ->onlyOnIndex(), // <--- L'affiche uniquement dans la liste
    ];
}
}