<?php

namespace App\Controller\Admin;

use App\Entity\Work;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WorkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Work::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Work')
            ->setEntityLabelInPlural('Work')
            ->setSearchFields(['id', 'title', 'longTitle', 'shortTitle', 'source', 'totalWords', 'totalParagraphs', 'genreType', 'year']);
    }

    public function configureFields(string $pageName): iterable
    {
        $title = TextField::new('title');
        $longTitle = TextField::new('longTitle');
        $shortTitle = TextField::new('shortTitle');
        $source = TextField::new('source');
        $totalWords = IntegerField::new('totalWords');
        $totalParagraphs = IntegerField::new('totalParagraphs');
        $genreType = TextField::new('genreType');
        $year = IntegerField::new('year');
        $chapters = AssociationField::new('chapters');
        $id = TextField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $title, $longTitle, $shortTitle, $source, $totalWords, $totalParagraphs];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $title, $longTitle, $shortTitle, $source, $totalWords, $totalParagraphs, $genreType, $year, $chapters];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$title, $longTitle, $shortTitle, $source, $totalWords, $totalParagraphs, $genreType, $year, $chapters];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$title, $longTitle, $shortTitle, $source, $totalWords, $totalParagraphs, $genreType, $year, $chapters];
        }
    }
}
