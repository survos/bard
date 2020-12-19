<?php

namespace App\Controller\Admin;

use App\Entity\Paragraph;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ParagraphCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Paragraph::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Paragraph')
            ->setEntityLabelInPlural('Paragraphs')
            ->setSearchFields(['id', 'plainText', 'section', 'charId', 'type']);
    }

    public function configureFields(string $pageName): iterable
    {
        $plainText = TextareaField::new('plainText');
        $section = IntegerField::new('section');
        $charId = TextField::new('charId');
        $type = TextField::new('type');
        $work = AssociationField::new('work');
        $scene = AssociationField::new('scene');
        $id = TextField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $section, $charId, $type, $work, $scene];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $plainText, $section, $charId, $type, $work, $scene];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$plainText, $section, $charId, $type, $work, $scene];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$plainText, $section, $charId, $type, $work, $scene];
        }
    }
}
