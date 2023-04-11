<?php

namespace App\Controller\Admin;

use App\Entity\Organization;
use App\Enum\OrganizationTypeEnum;
use App\Repository\OrganizationRepository;
use DateTime;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class OrganizationCrudController extends AbstractCrudController
{
    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Organization::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->entityRepository->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->andWhere('entity.deletionDate IS NULL');

        return $response;
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setDeletionDate(new Datetime('now'));
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Identifiant')
                ->hideOnForm(),
            BooleanField::new('status', 'Etat')
                ->hideOnIndex(),
            TextField::new('name', 'Nom'),
            ChoiceField::new('type', 'Type d\'organisation')
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
                ]),
            TextareaField::new('description', 'Description')
                ->hideOnIndex(),
            ImageField::new('logo', 'Logo')
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->setBasePath('/uploads/images/')
                ->setUploadDir('public/uploads/images/'),
            TextField::new('address', 'Adresse')
                ->hideOnIndex(),
            CountryField::new('country', 'Pays')
                ->hideOnIndex(),
            TextField::new('website', 'Site web')
                ->hideOnIndex(),
            TextField::new('email', 'Email'),
            TextField::new('phone', 'Téléphone')
                ->hideOnIndex(),
            TextField::new('siret', 'Numéro de Siret')
                ->hideOnIndex(),
            TextField::new('vat', 'Numéro de TVA intracomunautaire')
                ->hideOnIndex(),
            AssociationField::new('city', 'Ville/CP')
                ->hideOnIndex()
                ->autocomplete(),
            AssociationField::new('zipCode', 'Département')
                ->hideOnIndex(),
            AssociationField::new('contests', 'Nombre de concours')
                ->setQueryBuilder(function (OrganizationRepository $repository) {
                    $qb = $repository->createQueryBuilder('o');
                    $qb->select('COUNT(o.contests)');

                    return $qb;
                })
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
