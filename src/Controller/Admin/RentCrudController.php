<?php

namespace App\Controller\Admin;

use App\Entity\Rent;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Rent::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
