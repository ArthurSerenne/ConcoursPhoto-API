<?php

namespace App\Controller\Admin;

use App\Entity\Sponsor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SponsorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sponsor::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('facebook'),
            TextField::new('tiktok'),
            TextField::new('youtube'),
            TextField::new('whatsapp'),
            TextField::new('twitter'),
            TextField::new('snapchat'),
        ];
    }
}
