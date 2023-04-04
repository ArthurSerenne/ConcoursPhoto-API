<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Filter\MemberFilter;
use App\Entity\Member;
use App\Entity\Photo;
use App\Enum\CategoryEnum;
use App\Enum\SituationEnum;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Member::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $member = new Member();
        $member->setRegistrationDate(new Datetime('now'));
        $member->setUpdateDate(new Datetime('now'));

        return $member;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUpdateDate(new Datetime('now'));
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')
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
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->setLabel('Date de création'),
            DateField::new('deletionDate')
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->setLabel('Date de suppression')
                ->hideOnIndex(),
            DateField::new('updateDate')
                ->setLabel('Date de dernière modification')
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->hideOnIndex(),
            DateField::new('lastLoginDate')
                ->setLabel('Date de dernière connexion')
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->hideOnIndex(),
            ImageField::new('photo')
                ->setLabel('Avatar')
                ->setBasePath('/uploads/images/')
                ->setUploadDir('public/uploads/images/'),
            TextareaField::new('description')
                ->hideOnIndex()
                ->setLabel('Description'),
            ChoiceField::new('situation')
                ->setLabel('Situation')
                ->setChoices(SituationEnum::cases())
                ->setTranslatableChoices([
                    'salary' => 'Salarié',
                    'boss' => 'Patron',
                    'other' => 'Autre'
                ])
                ->hideOnIndex(),
            ChoiceField::new('category')
                ->setLabel('Catégorie')
                ->setChoices(CategoryEnum::cases())
                ->setTranslatableChoices([
                    'categ1' => 'Catégorie 1',
                    'categ2' => 'Catégorie 2',
                    'categ3' => 'Catégorie 3'
                ])
                ->hideOnIndex(),
            TextField::new('website')
                ->setLabel('Site web'),
            AssociationField::new('socialNetwork')
                ->setCrudController(SocialNetworkCrudController::class)
                ->setLabel('Réseaux Sociaux')
                ->renderAsEmbeddedForm()
                ->hideOnDetail()
                ->hideOnIndex(),
            CollectionField::new('photos', 'Concours en tant que photographe')
                ->allowAdd(false)
                ->allowDelete(false)
                ->setColumns(10)
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->hideOnIndex(),
            CollectionField::new('juryMembers', 'Concours en tant que membre du jury')
                ->allowAdd(false)
                ->allowDelete(false)
                ->setColumns(10)
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->setTextAlign(textAlign: 'right')
                ->hideOnIndex(),
        ];

        if (Crud::PAGE_DETAIL === $pageName) {
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
