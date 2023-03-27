<?php

namespace App\Controller\Admin;

use App\Entity\Contest;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
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
            NumberField::new('id')
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
                ->setLabel('Description'),
            TextField::new('rules')
                ->setLabel('Règles'),
            TextField::new('prizes')
                ->setLabel('Prix'),
            DateField::new('creationDate')
                ->hideOnIndex(),
            DateField::new('publicationDate')
                ->hideOnIndex(),
            DateField::new('submissionStartDate')
                ->hideOnIndex(),
            DateField::new('submissionEndDate')
                ->hideOnIndex(),
            DateField::new('votingStartDate')
                ->hideOnIndex(),
            DateField::new('votingEndDate')
                ->hideOnIndex(),
            DateField::new('resultsDate')
                ->hideOnIndex(),
            NumberField::new('juryVotePourcentage'),
            NumberField::new('voteMax'),
            NumberField::new('prizesCount'),
            NumberField::new('ageMin'),
            NumberField::new('ageMax'),
            AssociationField::new('cities')
                ->autocomplete()
                ->hideOnIndex(),
            AssociationField::new('departments')
                ->hideOnIndex(),
            AssociationField::new('regions')
                ->hideOnIndex(),
            TextField::new('country')
                ->setLabel('Pays'),
            AssociationField::new('theme')
                ->hideOnIndex(),
            AssociationField::new('categories')
                ->hideOnIndex(),
            AssociationField::new('organization')
                ->hideOnIndex(),
            AssociationField::new('photos')
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
