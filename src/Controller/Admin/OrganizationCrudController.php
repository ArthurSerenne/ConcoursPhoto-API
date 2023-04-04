<?php

namespace App\Controller\Admin;

use App\Entity\Organization;
use App\Enum\OrganizationTypeEnum;
use App\Repository\OrganizationRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrganizationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Organization::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->setLabel('Identifiant')
                ->hideOnForm(),
            BooleanField::new('status')
                ->hideOnIndex(),
            TextField::new('name'),
            ChoiceField::new('type')
                ->setChoices(OrganizationTypeEnum::cases())
                ->setTranslatableChoices([
                    'city' => 'Ville/Commune',
                    'community' => 'Communauté de communes',
                    'department' => 'Département',
                    'region' => 'Région',
                    'office' => 'Office de tourisme',
                    'country' => 'Pays',
                    'private' => 'Entreprise privée',
                    'ong' => 'Association/ONG',
                    'other' => 'Autre organisme'
                ])
                ->setLabel('Type d\'organisation'),
            TextField::new('description')
                ->hideOnIndex(),
            ImageField::new('logo')
                ->setBasePath('/uploads/images/')
                ->setUploadDir('public/uploads/images/'),
            TextField::new('address')
                ->hideOnIndex(),
            CountryField::new('country')
                ->hideOnIndex(),
            TextField::new('website')
                ->hideOnIndex(),
            TextField::new('email'),
            TextField::new('phone')
                ->hideOnIndex(),
            AssociationField::new('city')
                ->setLabel('Ville/CP')
                ->hideOnIndex()
                ->autocomplete(),
            AssociationField::new('zipCode')
                ->hideOnIndex()
                ->setLabel('Département'),
            AssociationField::new('contests')
                ->setQueryBuilder(function (OrganizationRepository $repository) {
                    $qb = $repository->createQueryBuilder('o');
                    $qb->select('COUNT(o.contests)');

                    return $qb;
                })
                ->setLabel('Nombre de concours')
                ->hideWhenUpdating()
                ->hideWhenCreating(),
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
            ->add('type')
            ->add('email');
    }
}
