<?php

namespace App\Controller\Admin;

use App\Entity\Sponsor;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SponsorCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Sponsor::class;
    }


    // public function createEntity(string $entityFqcn)
    // {

    // }

    // public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    // {
        
    // }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Identifiant')
                ->hideOnForm(),
            AssociationField::new('organization', 'Organisateur')
                ->hideOnIndex(),
            AssociationField::new('contest', 'Concours')
                ->hideOnIndex(),
            DateField::new('start_date', 'Date de début')
                ->hideOnDetail(),
            DateField::new('end_date', 'Date de fin')
                ->hideOnDetail(),
            NumberField::new('sponsor_rank', 'Sponsor Rank')
                ->hideOnDetail(),
            NumberField::new('amount', 'Amount')
                ->hideOnDetail(),
            ImageField::new('logo', 'Logo')
                ->setBasePath('/uploads/images/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setUploadDir('public/uploads/images/'),
            TextField::new('url', 'Url')
                ->hideOnDetail(),  
        ];  
    }
}
