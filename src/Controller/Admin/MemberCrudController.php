<?php

namespace App\Controller\Admin;

use App\Entity\Member;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

class MemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Member::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            NumberField::new('id')
                ->setLabel('Identifiant')
                ->hideOnForm(),
            AssociationField::new('user')
                ->setQueryBuilder(fn (QueryBuilder $queryBuilder) => $queryBuilder->getEntityManager()->getRepository(User::class)),
            TextField::new('username')
                ->setLabel('Pseudo'),
            BooleanField::new('status')
                ->setLabel('Etat')
                ->hideOnIndex(),
            DateField::new('registrationDate')
                ->hideOnIndex(),
            DateField::new('deletionDate')
                ->hideOnIndex(),
            DateField::new('updateDate')
                ->hideOnIndex(),
            DateField::new('lastLoginDate')
                ->hideOnIndex(),
            ImageField::new('photo')
                ->setLabel('Photo')
                ->setBasePath('/uploads/images/')
                ->setUploadDir('public/uploads/images/'),
            TextField::new('description')
                ->setLabel('Description'),
            ChoiceField::new('situation')
                ->setChoices([
                    'Employé' => 'employed',
                    'patron' => 'boss',
                    'Autre' => 'other',
                ])
                ->hideOnIndex(),
            ChoiceField::new('category')
                ->setChoices([
                    'Categ1' => 'categ1',
                    'Categ2' => 'categ2',
                    'Categ3' => 'categ3',
                ])
                ->hideOnIndex(),
            TextField::new('website')
                ->setLabel('Website'),
            AssociationField::new('socialNetwork')->setCrudController(SocialNetworkCrudController::class)
                ->setLabel('Réseaux Sociaux')
                ->hideOnIndex()
                ->renderAsEmbeddedForm(),
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
            ->add('username');
    }
}
