<?php

namespace App\Controller\Admin;

use App\Entity\Chapter;
use App\Entity\Character;
use App\Entity\GutenbergBook;
use App\Entity\Paragraph;
use App\Entity\Work;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Shakespeare');
    }

    public function configureCrud(): Crud
    {
        return Crud::new();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Bard Home', 'fas fa-folder-open', 'app_homepage');
        yield MenuItem::linkToCrud('Work', 'fas fa-folder-open', Work::class);
        yield MenuItem::linkToCrud('Chapter', 'fas fa-folder-open', Chapter::class);
        yield MenuItem::linkToCrud('Paragraph', 'fas fa-folder-open', Paragraph::class);
        yield MenuItem::linkToCrud('Character', 'fas fa-folder-open', Character::class);
        yield MenuItem::linkToCrud('GutenbergBook', 'fas fa-folder-open', GutenbergBook::class);
    }
}
