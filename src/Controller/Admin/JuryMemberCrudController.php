<?php

namespace App\Controller\Admin;

use App\Entity\JuryMember;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class JuryMemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JuryMember::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPaginatorPageSize(10)
            ->setPaginatorRangeSize(4)
        ;
    }
}
