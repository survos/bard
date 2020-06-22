<?php

namespace App\Controller\Admin;

use App\Entity\GutenbergBook;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GutenbergBookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GutenbergBook::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('GutenbergBook')
            ->setEntityLabelInPlural('GutenbergBook')
            ->setSearchFields(['id', 'title', 'rdf']);
    }

    public function configureFields(string $pageName): iterable
    {
        $title = TextField::new('title');
        $rdf = TextareaField::new('rdf');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $title, $rdf];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$title, $rdf];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$title, $rdf];
        }
    }
}
