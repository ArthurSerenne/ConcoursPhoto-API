<?php

namespace App\Controller\Admin;

use App\Entity\Contest;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

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
