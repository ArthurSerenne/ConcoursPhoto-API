<?php

namespace App\Controller\Admin;

use App\Entity\Organization;
use App\Enum\CountryEnum;
use App\Enum\OrganizationTypeEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class OrganizationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Organization::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            BooleanField::new('status'),
            TextField::new('name'),
            ChoiceField::new('type')
                ->setChoices(OrganizationTypeEnum::cases())
                ->setLabel('Type d\'organisation'),
            TextField::new('description'),
            ImageField::new('logo')
                ->setBasePath('/uploads/images/')
                ->setUploadDir('public/uploads/images/'),
            TextField::new('address'),
            ChoiceField::new('country')
                ->setChoices(CountryEnum::cases()),
            TextField::new('website'),
            TextField::new('email'),
            TextField::new('phone'),
            AssociationField::new('contests')
                ->hideWhenCreating()
                ->setColumns(8)
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
            ->add('type')
            ->add('email');
    }
}
