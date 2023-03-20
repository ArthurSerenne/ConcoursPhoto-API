<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
        
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        return parent::index();
        
        $url = $this->adminUrlGenerator
            ->setController(UserCrudController::class)
            ->setController(MemberCrudController::class)
            ->generateUrl();
        
        return $this->redirect($url);

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ConcoursPhoto API');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::subMenu('Actions')->setSubItems([
            MenuItem::linkToCrud('Users', 'fas fa-plus', User::class)
        ]);

        yield MenuItem::section('Member');

        yield MenuItem::section('User');

        yield MenuItem::section('User');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
