<?php

namespace App\Controller\Admin;

use App\Entity\Contest;
use App\Form\PhotoType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contest::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->setLabel('Identifiant')
                ->hideOnForm(),
            TextField::new('name')
                ->setLabel('Nom'),
            BooleanField::new('status')
                ->setLabel('Etat')
                ->hideOnIndex(),
            ImageField::new('visual')
                ->setLabel('Visuel')
                ->setBasePath('/uploads/images/')
                ->setUploadDir('public/uploads/images/'),
            TextField::new('description')
                ->setLabel('Description')
                ->hideOnIndex(),
            TextField::new('rules')
                ->setLabel('Règles')
                ->hideOnIndex(),
            TextField::new('prizes')
                ->setLabel('Prix')
                ->hideOnIndex(),
            DateField::new('creationDate')
                ->setLabel('Date de création')
                ->hideOnIndex(),
            DateField::new('publicationDate')
                ->setLabel('Date de publication')
                ->hideOnIndex(),
            DateField::new('submissionStartDate')
                ->setLabel('Date de début de soumission')
                ->hideOnIndex(),
            DateField::new('submissionEndDate')
                ->setLabel('Date de fin de soumission')
                ->hideOnIndex(),
            DateField::new('votingStartDate')
                ->setLabel('Date de début de vote')
                ->hideOnIndex(),
            DateField::new('votingEndDate')
                ->setLabel('Date de fin de vote')
                ->hideOnIndex(),
            DateField::new('resultsDate')
                ->setLabel('Date des résultats')
                ->hideOnIndex(),
            NumberField::new('juryVotePourcentage')
                ->setLabel('Vote des jury (%)')
                ->hideOnIndex(),
            NumberField::new('voteMax')
                ->setLabel('Nombre de vote max')
                ->hideOnIndex(),
            NumberField::new('prizesCount')
                ->setLabel('Nombre de prix')
                ->hideOnIndex(),
            NumberField::new('ageMin')
                ->setLabel('Âge minimal')
                ->hideOnIndex(),
            NumberField::new('ageMax')
                ->setLabel('Âge maximal')
                ->hideOnIndex(),
            AssociationField::new('cities')
                ->setLabel('Ville(s)')
                ->autocomplete()
                ->hideOnIndex(),
            AssociationField::new('departments')
                ->setLabel('Départements(s)')
                ->hideOnIndex(),
            AssociationField::new('regions')
                ->setLabel('Régions(s)')
                ->hideOnIndex(),
            CountryField::new('country')
                ->setLabel('Pays')
                ->hideOnIndex(),
            AssociationField::new('themes')
                ->setLabel('Thème(s)')
                ->hideOnIndex(),
            AssociationField::new('categories')
                ->setLabel('Catégorie(s)')
                ->hideOnIndex(),
            AssociationField::new('organization')
                ->setLabel('Organisateur')
                ->hideWhenCreating(),
            CollectionField::new('photos')
                ->useEntryCrudForm()
                ->hideOnIndex()
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(10)
            ->setPaginatorRangeSize(4)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('status')
            ->add('name')
            ->add('description')
            ->add('rules')
            ->add('prizes');
    }
}
