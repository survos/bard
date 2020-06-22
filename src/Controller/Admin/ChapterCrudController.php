<?php

namespace App\Controller\Admin;

use App\Entity\Chapter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ChapterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chapter::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Chapter')
            ->setEntityLabelInPlural('Chapter')
            ->setSearchFields(['id', 'section', 'scene', 'description']);
    }

    public function configureFields(string $pageName): iterable
    {
        $section = IntegerField::new('section');
        $scene = TextField::new('scene');
        $description = TextField::new('description');
        $work = AssociationField::new('work');
        $paragraphs = AssociationField::new('paragraphs');
        $id = TextField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $section, $scene, $description, $work, $paragraphs];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $section, $scene, $description, $work, $paragraphs];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$section, $scene, $description, $work, $paragraphs];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$section, $scene, $description, $work, $paragraphs];
        }
    }
}
