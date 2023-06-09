<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Filter\MemberFilter;
use App\Entity\Member;
use App\Entity\SocialNetwork;
use App\Enum\CategoryEnum;
use App\Enum\SituationEnum;
use Doctrine\ORM\EntityManagerInterface;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
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
        $member->setRegistrationDate(new \DateTime('now'));
        $member->setUpdateDate(new \DateTime('now'));
        $member->setSocialNetwork($socialNetwork);
        $socialNetwork->setMember($member);
        $this->handleImageUpload($member);

        return $member;
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setDeletionDate(new \DateTime('now'));
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUpdateDate(new \DateTime('now'));
        $this->handleImageUpload($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function handleImageUpload(Member $member): void
    {
        $uploadedFile = $member->getPhoto();
        if ($uploadedFile instanceof UploadedFile) {
            $newFileName = uniqid().'.'.$uploadedFile->getClientOriginalExtension();
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
                ->setRequired(Crud::PAGE_NEW === $pageName)
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
                    'other' => 'Autre',
                ])
                ->hideOnIndex(),
            ChoiceField::new('category', 'Catégorie')
                ->setChoices(CategoryEnum::cases())
                ->setTranslatableChoices([
                    'categ1' => 'Catégorie 1',
                    'categ2' => 'Catégorie 2',
                    'categ3' => 'Catégorie 3',
                ])
                ->hideOnIndex(),
            UrlField::new('website', 'Site web'),
            AssociationField::new('socialNetwork')
                ->setCrudController(SocialNetworkCrudController::class)
                ->renderAsEmbeddedForm()
                ->hideOnDetail()
                ->hideOnIndex(),
        ];

        if (Crud::PAGE_DETAIL === $pageName) {
            $fields[] = UrlField::new('socialNetwork.facebook', 'Facebook');
            $fields[] = UrlField::new('socialNetwork.twitter', 'Twitter');
            $fields[] = UrlField::new('socialNetwork.linkedin', 'LinkedIn');
            $fields[] = UrlField::new('socialNetwork.youtube', 'YouTube');
            $fields[] = UrlField::new('socialNetwork.instagram', 'Instagram');
            $fields[] = UrlField::new('socialNetwork.tiktok', 'TikTok');
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
