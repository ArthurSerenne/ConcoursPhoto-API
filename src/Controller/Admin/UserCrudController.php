<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Enum\GenderEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
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
            IdField::new('id')
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
                ->setLabel('Ville/CP')
                ->autocomplete(),
            AssociationField::new('zipCode')
                ->setLabel('Département'),
            TextField::new('address')
                ->setLabel('Adresse')
                ->hideOnIndex(),
            CountryField::new('country')
                ->setLabel('Pays')
                ->hideOnIndex(),
            BooleanField::new('status')
                ->setLabel('Etat')
                ->hideOnIndex(),
            DateField::new('creationDate')
                ->setLabel('Date de création')
                ->hideOnIndex(),
            DateField::new('birthdate')
                ->setLabel('Date de naissance')
                ->hideOnIndex(),
            ChoiceField::new('gender')
                ->setLabel('Genre')
                ->setChoices(GenderEnum::cases())
                ->hideOnIndex(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Utilisateurs')
            ->setPaginatorPageSize(10)
            ->setPaginatorRangeSize(4)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('firstname')
            ->add('lastname')
            ->add('address')
            ->add('country')
            ->add('roles');
    }
}
