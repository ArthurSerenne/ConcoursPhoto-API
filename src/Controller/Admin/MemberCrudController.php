<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Filter\MemberFilter;
use App\Entity\Member;
use App\Enum\CategoryEnum;
use App\Enum\SituationEnum;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
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
    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Member::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->entityRepository->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->andWhere('entity.deletionDate IS NULL');

        return $response;
    }

    public function createEntity(string $entityFqcn)
    {
        $member = new Member();
        $member->setRegistrationDate(new Datetime('now'));
        $member->setUpdateDate(new Datetime('now'));

        return $member;
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setDeletionDate(new Datetime('now'));
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUpdateDate(new Datetime('now'));
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id', 'Identifiant')
                ->hideOnForm(),
            AssociationField::new('user', 'Utilisateur')
                ->setQueryBuilder(function (QueryBuilder $queryBuilder) {
                    $queryBuilder->select('u')
                        ->from('App\Entity\User', 'u')
                        ->leftJoin('u.member', 'm')
                        ->where('m.id IS NULL');

                    return $queryBuilder;
                })
                ->hideWhenUpdating(),
            TextField::new('username', 'Pseudo'),
            BooleanField::new('status', 'Etat')
                ->hideOnIndex(),
            DateField::new('registrationDate', 'Date de création')
                ->hideWhenUpdating()
                ->hideWhenCreating(),
            DateField::new('deletionDate', 'Date de suppression')
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->hideOnIndex(),
            DateField::new('updateDate', 'Date de dernière modification')
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->hideOnIndex(),
            DateField::new('lastLoginDate', 'Date de dernière connexion')
                ->hideWhenUpdating()
                ->hideWhenCreating()
                ->hideOnIndex(),
            ImageField::new('photo', 'Avatar')
                ->setBasePath('/uploads/images/')
                ->setUploadDir('public/uploads/images/'),
            TextareaField::new('description', 'Description')
                ->hideOnIndex(),
            ChoiceField::new('situation', 'Situation')
                ->setChoices(SituationEnum::cases())
                ->setTranslatableChoices([
                    'salary' => 'Salarié',
                    'student' => 'Etudiant',
                    'unemployment' => 'Au chômage',
                    'other' => 'Autre'
                ])
                ->hideOnIndex(),
            ChoiceField::new('category', 'Catégorie')
                ->setChoices(CategoryEnum::cases())
                ->setTranslatableChoices([
                    'categ1' => 'Catégorie 1',
                    'categ2' => 'Catégorie 2',
                    'categ3' => 'Catégorie 3'
                ])
                ->hideOnIndex(),
            TextField::new('website', 'Site web'),
            AssociationField::new('socialNetwork')
                ->setCrudController(SocialNetworkCrudController::class)
                ->renderAsEmbeddedForm()
                ->hideOnDetail()
                ->hideOnIndex(),
        ];

        if (Crud::PAGE_DETAIL === $pageName) {
            $fields[] = TextField::new('socialNetwork.facebook', 'Facebook');
            $fields[] = TextField::new('socialNetwork.twitter', 'Twitter');
            $fields[] = TextField::new('socialNetwork.linkedin', 'LinkedIn');
            $fields[] = TextField::new('socialNetwork.whatsapp', 'WhatsApp');
            $fields[] = TextField::new('socialNetwork.youtube', 'YouTube');
            $fields[] = TextField::new('socialNetwork.instagram', 'Instagram');
            $fields[] = TextField::new('socialNetwork.tiktok', 'TikTok');
            $fields[] = TextField::new('socialNetwork.snapchat', 'Snapchat');
        }

        $fields[] = CollectionField::new('photos', 'Concours en tant que photographe')
            ->onlyOnDetail()
            ->setTemplatePath('admin/member/photographer.html.twig');

        $fields[] = CollectionField::new('juryMembers', 'Concours en tant que membre du jury')
            ->onlyOnDetail()
            ->setTemplatePath('admin/member/jury-member.html.twig');

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
