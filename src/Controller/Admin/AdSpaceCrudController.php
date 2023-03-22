<?php

namespace App\Controller\Admin;

use App\Entity\AdSpace;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdSpaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AdSpace::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(10)
            ->setPaginatorRangeSize(4)
            ;
    }
}
