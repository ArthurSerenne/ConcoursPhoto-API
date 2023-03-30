<?php

namespace App\Controller\Admin;

use App\Entity\AdSpace;
use App\Entity\Contest;
use App\Entity\JuryMember;
use App\Entity\Member;
use App\Entity\Organization;
use App\Entity\Photo;
use App\Entity\Sponsor;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_SUPER_ADMIN')]
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
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ConcoursPhoto BO')
            ->setLocales(['fr', 'en']);
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::subMenu('Users')->setSubItems([
        //     MenuItem::linkToCrud('Show users', 'fas fa-plus', User::class)
        // ]);

        // yield MenuItem::subMenu('Members')->setSubItems([
        //     MenuItem::linkToCrud('Show members', 'fas fa-plus', Member::class)
        // ]);

        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Membres', 'fas fa-user-tie', Member::class);
//        yield MenuItem::linkToCrud('Membres du jury', 'fas fa-users', JuryMember::class);
//        yield MenuItem::linkToCrud('Publicités', 'fas fa-ad', AdSpace::class);
        yield MenuItem::linkToCrud('Organisations', 'fas fa-sitemap', Organization::class);
        yield MenuItem::linkToCrud('Concours', 'fas fa-trophy', Contest::class);
//        yield MenuItem::linkToCrud('Photos', 'fas fa-image', Photo::class);
//        yield MenuItem::linkToCrud('Sponsors', 'fas fa-handshake', Sponsor::class);

        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }

    /**
     * @param UserInterface|User $user
     */
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->addMenuItems([
                MenuItem::linkToRoute('Modifier mon compte', 'fas fa-user-edit', 'admin_edit_account'),
            ]);
    }
}
