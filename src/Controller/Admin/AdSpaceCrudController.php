<?php

namespace App\Controller\Admin;

use App\Entity\AdSpace;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdSpaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AdSpace::class;
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
