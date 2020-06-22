<?php

namespace App\Controller\Admin;

use App\Entity\Character;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CharacterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Character::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Character')
            ->setEntityLabelInPlural('Character')
            ->setSearchFields(['id', 'name', 'description']);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $description = TextField::new('description');
        $id = TextField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $description];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $description];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $description];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $description];
        }
    }
}
