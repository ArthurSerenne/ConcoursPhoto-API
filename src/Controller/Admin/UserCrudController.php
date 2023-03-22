<?php

namespace App\Controller\Admin;

use App\Entity\City;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            NumberField::new('id')
                ->setLabel('Identifiant')
                ->hideOnForm(),
            TextField::new('firstname')
                ->setLabel('Prénom'),
            TextField::new('lastname')
                ->setLabel('Nom'),
            EmailField::new('email')
                ->setLabel('Email'),
            TextField::new('phone')
                ->setLabel('Téléphone')
                ->hideOnIndex(),
            TextField::new('password')
                ->setLabel('Mot de passe')
                ->hideOnIndex(),
            AssociationField::new('city')
                ->setLabel('Ville/CP'),
            AssociationField::new('zipCode')
                ->setLabel('Département'),
            TextField::new('address')
                ->setLabel('Adresse')
                ->hideOnIndex(),
            ChoiceField::new('country')
                ->setChoices([
                    'France' => 'france',
                ])
                ->hideOnIndex(),
            BooleanField::new('status')
                ->setLabel('Etat')
                ->hideOnIndex(),
            DateField::new('creationDate')
                ->hideOnIndex(),
            DateField::new('birthdate')
                ->hideOnIndex(),
            ChoiceField::new('gender')
                ->setChoices([
                    'Homme' => 'male',
                    'Femme' => 'female',
                    'Autre' => 'other',
                ])
                ->hideOnIndex(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(10)
            ->setPaginatorRangeSize(4)
            ;
    }
}
