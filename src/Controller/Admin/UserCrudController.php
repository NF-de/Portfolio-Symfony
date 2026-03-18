<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
public function configureCrud(Crud $crud): Crud
{
    return $crud
        // En forçant le tri par ID, EasyAdmin ignorera 
        // les paramètres de tri erronés dans l'URL
        ->setDefaultSort(['id' => 'DESC']);
}

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom'),
            TextField::new('prenom', 'Prénom'),
            EmailField::new('email', 'Email'),

            // On affiche une liste avec un seul choix possible : Admin
            // Si coché -> ROLE_ADMIN est ajouté au tableau
            // Si décoché -> le tableau devient vide [] (mais l'entité garde ROLE_USER via son code)
            ChoiceField::new('roles', 'Droits d\'accès')
                ->setChoices([
                    'Accès Administrateur' => 'ROLE_ADMIN',
                ])
                ->allowMultipleChoices()
                ->renderExpanded() // Transforme en case à cocher unique
        ];
    }
    
}