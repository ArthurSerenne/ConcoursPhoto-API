<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Photo::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            BooleanField::new('status', 'Etat'),
            TextField::new('name', 'Nom'),
            ImageField::new('file', 'Fichier')
                ->formatValue(static function ($value, Photo $photo) {
                    return '/uploads/images/'.$photo->getFile();
                })
                ->setBasePath('/uploads/images/')
                ->setUploadDir('public/uploads/images/'),
            DateField::new('submissionDate', 'Date de soumission'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(10)
            ->setPaginatorRangeSize(4)
        ;
    }
}
