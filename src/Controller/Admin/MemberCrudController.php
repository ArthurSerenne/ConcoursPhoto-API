<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Filter\MemberFilter;
use App\Entity\Member;
use App\Entity\SocialNetwork;
use App\Enum\CategoryEnum;
use App\Enum\SituationEnum;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
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
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
        $socialNetwork = new SocialNetwork();
        $member->setRegistrationDate(new Datetime('now'));
        $member->setUpdateDate(new Datetime('now'));
        $member->setSocialNetwork($socialNetwork);
        $socialNetwork->setMember($member);
        $this->handleImageUpload($member);

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
        $this->handleImageUpload($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function handleImageUpload(Member $member): void
    {
        $uploadedFile = $member->getPhoto();
        if ($uploadedFile instanceof UploadedFile) {
            $newFileName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->move($this->getParameter('uploads_images_directory'), $newFileName);
            $member->setPhoto($newFileName);
        }
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
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->formatValue(static function ($value, Member $member) {
                    return '/uploads/images/'.$member->getPhoto();
                })
                ->setBasePath('/uploads/images/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
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

        $fields[] = CollectionField::new('juryMembers', 'Concours en tant que jury')
            ->onlyOnDetail()
            ->setTemplatePath('admin/member/jury-member.html.twig');

        $fields[] = CollectionField::new('photos', 'Photos')
            ->onlyOnDetail()
            ->setCustomOption('max_items_per_page', 6)
            ->setTemplatePath('admin/member/photographer.html.twig');

        return $fields;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Membres')
            ->setPageTitle('detail', 'Vue du membre')
            ->setPageTitle('edit', 'Modification du membre')
            ->setPageTitle('new', 'Ajouter un membre')
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
