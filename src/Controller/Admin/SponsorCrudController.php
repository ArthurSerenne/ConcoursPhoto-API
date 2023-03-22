<?php

namespace App\Controller\Admin;

use App\Entity\Sponsor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SponsorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sponsor::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(10)
            ->setPaginatorRangeSize(4)
            ;
    }
}
