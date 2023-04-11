<?php

namespace App\Controller\Admin;

use App\Entity\Contest;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;

class ContestCrudController extends AbstractCrudController
{
    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Contest::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->entityRepository->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->andWhere('entity.deletionDate IS NULL');

        return $response;
    }

    public function createEntity(string $entityFqcn)
    {
        $contest = new Contest();
        $contest->setCreationDate(new Datetime('now'));

        return $contest;
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
            TextField::new('name', 'Nom')
                ->hideOnDetail(),
            BooleanField::new('status', 'Etat')
                ->hideOnIndex(),
            BooleanField::new('trend', 'A la une')
                ->hideOnIndex(),
            ImageField::new('visual', 'Visuel')
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->formatValue(static function ($value, Contest $contest) {
                    return '/uploads/images/'.$contest->getVisual();
                })
                ->setBasePath('/uploads/images/')
                ->setUploadDir('public/uploads/images/'),
            TextareaField::new('description', 'Description')
                ->hideOnIndex(),
            TextareaField::new('rules', 'Règles')
                ->hideOnIndex(),
            TextareaField::new('prizes', 'Prix')
                ->hideOnIndex(),
            DateField::new('publicationDate', 'Date de publication')
                ->hideOnIndex(),
            DateField::new('submissionStartDate', 'Date de début de soumission')
                ->hideOnIndex(),
            DateField::new('submissionEndDate', 'Date de fin de soumission')
                ->hideOnIndex(),
            DateField::new('votingStartDate', 'Date de début de vote')
                ->hideOnIndex(),
            DateField::new('votingEndDate', 'Date de fin de vote')
                ->hideOnIndex(),
            DateField::new('resultsDate', 'Date des résultats')
                ->hideOnIndex(),
            NumberField::new('juryVotePourcentage', 'Vote des jury (%)')
                ->hideOnIndex(),
            NumberField::new('voteMax', 'Nombre de vote max')
                ->hideOnIndex(),
            NumberField::new('prizesCount', 'Nombre de prix')
                ->hideOnIndex(),
            NumberField::new('ageMin', 'Âge minimal')
                ->hideOnIndex(),
            NumberField::new('ageMax', 'Âge maximal')
                ->hideOnIndex(),
            AssociationField::new('cities', 'Ville(s)')
                ->autocomplete()
                ->hideOnDetail()
                ->hideOnIndex(),
            CollectionField::new('cities', 'Ville(s)')
                ->onlyOnDetail(),
            AssociationField::new('departments', 'Départements(s)')
                ->hideOnDetail()
                ->hideOnIndex(),
            CollectionField::new('departments', 'Départements(s)')
                ->onlyOnDetail(),
            AssociationField::new('regions', 'Régions(s)')
                ->hideOnDetail()
                ->hideOnIndex(),
            CollectionField::new('regions', 'Région(s)')
                ->onlyOnDetail(),
            CountryField::new('country', 'Pays')
                ->hideOnIndex(),
            AssociationField::new('themes', 'Thème(s)')
                ->hideOnDetail()
                ->hideOnIndex(),
            CollectionField::new('themes', 'Thème(s)')
                ->onlyOnDetail(),
            AssociationField::new('categories', 'Catégorie(s)')
                ->hideOnDetail()
                ->hideOnIndex(),
            CollectionField::new('categories', 'Catégorie(s)')
                ->onlyOnDetail(),
            AssociationField::new('organization', 'Organisateur')
                ->hideOnIndex(),
            CollectionField::new('photos', 'Photo(s)')
                ->allowAdd(false)
                ->hideWhenCreating()
                ->useEntryCrudForm()
                ->hideOnDetail()
                ->hideOnIndex(),
            CollectionField::new('photos', 'Photo(s)')
                ->setTemplatePath('admin/contest/photos.html.twig')
                ->onlyOnDetail(),
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
