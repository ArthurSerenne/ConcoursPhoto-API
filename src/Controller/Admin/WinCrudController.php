<?php

namespace App\Controller\Admin;

use App\Entity\Win;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class WinCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Win::class;
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
