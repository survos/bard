<?php

namespace App\EventSubscriber;

use App\Entity\Character;
use App\Entity\Work;
use Survos\LandingBundle\Traits\KnpMenuHelperTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class MenuSubscriber implements EventSubscriberInterface
{
    use KnpMenuHelperTrait;

    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->security = $security;
    }

    // could move this to the trait, if $security is visible
    private function isGranted(string $attribute, $subject=null) {
        return $this->security->isGranted($attribute, $subject);
    }


    public function onKnpMenuEvent(KnpMenuEvent $event)
    {
        $menu = $event->getMenu();
        $request = $this->requestStack->getCurrentRequest();

        $this->addMenuItem($menu, ['route' => 'app_homepage', 'label' => 'Home', 'icon' => 'fas fa-home']);
        $worksMenu = $this->addMenuItem($menu, ['menu_code' => 'works_header', 'icon' => 'fas fa-theater-masks']);
        $this->addMenuItem($worksMenu, ['route' => 'work_index', 'icon' => 'fas fa-list']);
        $this->addMenuItem($worksMenu, ['route' => 'work_datatable', 'icon' => 'fas fa-table']);
//        $menu->addChild('work_index.title', ['route' => 'work_index'])->setAttribute('icon', 'fas fa-theater-masks');
//        $menu->addChild('datatable', ['route' => 'work_datatable'])->setAttribute('icon', 'fas fa-table');

        $charactersMenu = $this->addMenuItem($menu, ['menu_code' => 'characters_header', 'icon' => 'fas fa-users']);
        $this->addMenuItem($charactersMenu, ['route' => 'character_index', 'icon' => 'fas fa-list']);
        $this->addMenuItem($charactersMenu, ['label' => 'DataTable(HTML)', 'route' => 'character_datatable', 'icon' => 'fas fa-table']);
        $this->addMenuItem($charactersMenu, ['label' => 'DataTable(API)', 'route' => 'character_datatable_via_api', 'icon' => 'fas fa-exchange-alt']);
        $this->addMenuItem($charactersMenu, ['route' => 'character_new', 'icon' => 'fas fa-plus']);

        $this->addMenuItem($menu, ['route' => 'app_typography', 'label' => 'Bootstrap 4', 'icon' => 'fab fa-bootstrap']);
        $this->addMenuItem($menu, ['route' => 'survos_bootstrap3', 'label' => 'Bootstrap 3', 'icon' => 'fab fa-bootstrap']);
        $this->addMenuItem($menu, ['route' => 'survos_landing_credits', 'icon' => 'fas fa-trophy']);


// $menu->addChild('test_rdf', ['route' => 'test_rdf'])->setAttribute('icon', 'fas fa-sync');
        $this->addMenuItem($menu, ['route' => 'easyadmin', 'label' => 'EasyAdmin', 'icon' => 'fas fa-database']);
        $this->addMenuItem($menu, ['route' => 'api_entrypoint', 'label' => 'API', 'icon' => 'fas fa-exchange-alt']);

        // ...
    }

    public function onKnpTopMenuEvent(KnpMenuEvent $event)
    {
        $isAdmin = $this->security->isGranted("ROLE_ADMIN");
        $menu = $event->getMenu();

        $request = $this->requestStack->getCurrentRequest();

        /** @var Work $work */
        if ($work = $request->get('work')) {
            $workMenu = $menu;
            // $workMenu = $this->addMenuItem($menu, ['menu_code' => $work->getSlug(), 'label' => 'Work: ' . $work->getTitle()]);
            $this->addMenuItem($workMenu, ['route' => 'work_show', 'rp' => $work]);
            // too similar right now$this->addMenuItem($workMenu, ['route' => 'admin_work_show', 'rp' => $work]);
            $this->addMenuItem($workMenu, ['route' => 'work_characters', 'rp' => $work]);
            $this->addMenuItem($workMenu, ['route' => 'work_chapters', 'rp' => $work]);
            $this->addMenuItem($workMenu, ['route' => 'work_text', 'rp' => $work]);
            if ($this->isGranted('WORK_ADMIN', $work)) {
                $this->addMenuItem($workMenu, ['route' => 'work_edit', 'rp' => $work]);
            }

        }

        /** @var Character $character */
        if ($character = $request->get('character')) {
            // $scriptMenu = $this->addMenuItem($menu, ['menu_code' => $script->getSlug(), 'label' => 'Script: ' . $script->getTitle()]);
            $this->addMenuItem($menu, ['route' => 'character_show', 'rp' => $character]);
            $this->addMenuItem($menu, ['route' => 'character_scenes', 'rp' => $character]);
            $this->addMenuItem($menu, ['route' => 'character_edit', 'rp' => $character]);
        }

    }


    public static function getSubscribedEvents()
    {
        return [
            'topMenuEvent' => 'onKnpTopMenuEvent',
            KnpMenuEvent::class => 'onKnpMenuEvent',
        ];
    }
}
