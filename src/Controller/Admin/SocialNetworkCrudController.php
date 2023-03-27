<?php

namespace App\Controller\Admin;

use App\Entity\SocialNetwork;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SocialNetworkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SocialNetwork::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            NumberField::new('id')
                ->setLabel('Identifiant')
                ->hideOnForm(),
            TextField::new('facebook')
                ->setLabel('Facebook'),
            TextField::new('twitter')
                ->setLabel('Twitter'),
            TextField::new('linkedin')
                ->setLabel('Linkedin'),
            TextField::new('whatsapp')
                ->setLabel('Whatsapp'),
            TextField::new('youtube')
                ->setLabel('Youtube'),
            TextField::new('instagram')
                ->setLabel('Instagram'),
            TextField::new('tiktok')
                ->setLabel('TikTok'),
            TextField::new('snapchat')
                ->setLabel('Snapchat'),
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
