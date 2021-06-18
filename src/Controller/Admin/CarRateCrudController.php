<?php

namespace App\Controller\Admin;

use App\Entity\CarRate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CarRateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CarRate::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            MoneyField::new('rateByHour')->setCurrency('USD'),
            MoneyField::new('rateByDay')->setCurrency('USD'),
            MoneyField::new('rateByKm')->setCurrency('USD'),
            AssociationField::new('car')
        ];
    }
}
