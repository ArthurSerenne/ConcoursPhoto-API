<?php

namespace App\Controller\Admin\Filter;

use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MemberFilter implements FilterInterface
{
    use FilterTrait;

    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setFilterFqcn(__CLASS__)
            ->setLabel($label)
            ->setProperty($propertyName)
            ->setFormType(ChoiceType::class)
            ->setFormTypeOptions([
                "choices" => ["Membres" => 1, "Photographes" => 2, "Jurys" => 3],
                "expanded" => true,
            ])
            ;
    }

    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {
        if ($filterDataDto->getValue() === 2) {
            $alias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->join($alias.'.photos', 'p')
                ->andWhere('p.id IS NOT NULL')
                ->groupBy($alias.'.id');
        }
        if ($filterDataDto->getValue() === 3) {
            $alias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->join($alias.'.juryMembers', 'j')
                ->andWhere('j.id IS NOT NULL')
                ->groupBy($alias.'.id');
        }
    }
}
