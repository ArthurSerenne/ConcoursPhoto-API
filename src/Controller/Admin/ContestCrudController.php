<?php

namespace App\Controller\Admin;

use App\Entity\Contest;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contest::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(10)
            ->setPaginatorRangeSize(4)
            ;
    }
}
