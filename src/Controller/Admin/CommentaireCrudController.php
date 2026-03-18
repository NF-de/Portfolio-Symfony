<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            // Le contenu du commentaire
            TextareaField::new('contenu', 'Message'),

            // IMPORTANT : On utilise 'user' (la propriété dans Commentaire.php)
            AssociationField::new('user', 'Auteur'),

            // IMPORTANT : On utilise 'article' (et non 'article_id')
            AssociationField::new('article', 'Article concerné'),

            // La date gérée par le PrePersist de l'entité
            DateTimeField::new('created_at', 'Posté le')
                ->setFormat('dd/MM/yyyy HH:mm')
                ->onlyOnIndex(),
        ];
    }
}