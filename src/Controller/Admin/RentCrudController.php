<?php

namespace App\Controller\Admin;

use App\Entity\Rent;
use App\Entity\AdSpace;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\EntityManagerInterface;

class RentCrudController extends AbstractCrudController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Rent::class;
    }
    

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Identifiant')
                ->hideOnForm(),
            AssociationField::new('organization', 'Organisateur')
                ->hideOnIndex()
                ->hideOnDetail(),
            AssociationField::new('adSpace', 'AdSpace')
                ->hideOnDetail()
                ->hideonIndex(),
            // ChoiceField::new('adSpace', 'Publicité')
            //     ->hideOnIndex()
            //     ->hideOnDetail()
            //     ->setChoices(function () {
            //         $adSpaces = $this->entityManager->getRepository(AdSpace::class)->findAll();
            //         $choices = [];

            //         foreach ($adSpaces as $adSpace) {
            //             $choices[$adSpace->getName()] = $adSpace->getName();
            //         }

            //         return $choices;
            //     }),
            DateField::new('start_date', 'Date de publication')
                ->hideOnIndex(),
            DateField::new('end_date', 'Date de fin')
                ->hideOnIndex(),
            TextField::new('click_url', 'Url')
                ->hideOnDetail(),
            TextField::new('alt_tag', 'Tag')
                ->hideOnDetail(),
            NumberField::new('price_sold', 'Prix')
                ->hideOnDetail(),
            NumberField::new('click_count', 'Clic')
                ->hideOnDetail(),
            ImageField::new('file', 'image de pub')
                ->setBasePath('/uploads/images/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setUploadDir('public/uploads/images/'),
        ];  
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
