<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Filter\MemberFilter;
use App\Entity\Member;
use App\Enum\CategoryEnum;
use App\Enum\SituationEnum;
use App\Repository\MemberRepository;
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
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

class MemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Member::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            NumberField::new('id')
                ->setLabel('Identifiant')
                ->hideOnForm(),
            AssociationField::new('user')
                ->setQueryBuilder(function (QueryBuilder $queryBuilder) {
                    $queryBuilder->select('u')
                        ->from('App\Entity\User', 'u')
                        ->leftJoin('u.member', 'm')
                        ->where('m.id IS NULL');

                    return $queryBuilder;
                })
                ->hideWhenUpdating(),
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
                ->setLabel('Avatar')
                ->setBasePath('/uploads/images/')
                ->setUploadDir('public/uploads/images/'),
            TextField::new('description')
                ->setLabel('Description'),
            ChoiceField::new('situation')
                ->setChoices(SituationEnum::cases())
                ->hideOnIndex(),
            ChoiceField::new('category')
                ->setChoices(CategoryEnum::cases())
                ->hideOnIndex(),
            TextField::new('website')
                ->setLabel('Website'),
            AssociationField::new('socialNetwork')
                ->setCrudController(SocialNetworkCrudController::class)
                ->setLabel('Réseaux Sociaux')
                ->renderAsEmbeddedForm()
                ->hideOnDetail()
                ->hideOnIndex(),
        ];

        if ($pageName === Crud::PAGE_DETAIL) {
            $fields[] = TextField::new('socialNetwork.facebook')->setLabel('Facebook');
            $fields[] = TextField::new('socialNetwork.twitter')->setLabel('Twitter');
            $fields[] = TextField::new('socialNetwork.linkedin')->setLabel('LinkedIn');
            $fields[] = TextField::new('socialNetwork.whatsapp')->setLabel('WhatsApp');
            $fields[] = TextField::new('socialNetwork.youtube')->setLabel('YouTube');
            $fields[] = TextField::new('socialNetwork.instagram')->setLabel('Instagram');
            $fields[] = TextField::new('socialNetwork.tiktok')->setLabel('TikTok');
            $fields[] = TextField::new('socialNetwork.snapchat')->setLabel('Snapchat');
        }

        return $fields;
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
            ->add('username')
            ->add(MemberFilter::new('statut'));
    }
}
