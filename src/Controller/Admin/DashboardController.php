<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Member;
use App\Entity\JuryMember;
use App\Entity\AdSpace;
use App\Entity\City;
use App\Entity\Contest;
use App\Entity\Departments;
use App\Entity\Organization;
use App\Entity\Photo;
use App\Entity\Regions;
use App\Entity\Rent;
use App\Entity\SocialNetwork;
use App\Entity\Sponsor;
use App\Entity\Vote;
use App\Entity\Win;
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
        // yield MenuItem::subMenu('Users')->setSubItems([
        //     MenuItem::linkToCrud('Show users', 'fas fa-plus', User::class)
        // ]);

        // yield MenuItem::subMenu('Members')->setSubItems([
        //     MenuItem::linkToCrud('Show members', 'fas fa-plus', Member::class)
        // ]);

        yield MenuItem::linkToCrud('Users', 'fas fa-plus', User::class);
        yield MenuItem::linkToCrud('Members', 'fas fa-plus', Member::class);
        yield MenuItem::linkToCrud('JuryMember', 'fas fa-plus', JuryMember::class);
        yield MenuItem::linkToCrud('AdSpace', 'fas fa-plus', AdSpace::class);
        yield MenuItem::linkToCrud('Contest', 'fas fa-plus', Contest::class);
        yield MenuItem::linkToCrud('Organization', 'fas fa-plus', Organization::class);
        yield MenuItem::linkToCrud('Photo', 'fas fa-plus', Photo::class);
        yield MenuItem::linkToCrud('Rent', 'fas fa-plus', Rent::class);
        yield MenuItem::linkToCrud('Sponsor', 'fas fa-plus', Sponsor::class);
    
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
