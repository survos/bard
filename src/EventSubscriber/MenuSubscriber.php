<?php

namespace App\EventSubscriber;

use App\Entity\Work;
use Survos\LandingBundle\Traits\KnpMenuHelperTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuSubscriber implements EventSubscriberInterface
{
    use KnpMenuHelperTrait;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function onKnpMenuEvent(KnpMenuEvent $event)
    {
        $menu = $event->getMenu();
        $request = $this->requestStack->getCurrentRequest();

        $menu->addChild('survos_landing', ['route' => 'app_homepage'])->setAttribute('icon', 'fas fa-home');

        $menu->addChild('survos_landing_credits', ['route' => 'survos_landing_credits'])->setAttribute('icon', 'fas fa-trophy');
        $menu->addChild('app_typography', ['route' => 'app_typography'])->setAttribute('icon', 'fab fa-bootstrap');

        $menu->addChild('work_index.title', ['route' => 'work_index'])->setAttribute('icon', 'fas fa-theater-masks');

// $menu->addChild('test_rdf', ['route' => 'test_rdf'])->setAttribute('icon', 'fas fa-sync');
        $menu->addChild('datatable', ['route' => 'work_datatable'])->setAttribute('icon', 'fas fa-table');
        $menu->addChild('api', ['route' => 'api_entrypoint'])->setAttribute('icon', 'fas fa-exchange-alt');
        $menu->addChild('easyadmin', ['route' => 'easyadmin'])->setAttribute('icon', 'fas fa-database');

        /** @var Work $work */
        if ($work = $request->get('work')) {
            $workMenu = $this->addMenuItem($menu, ['menu_code' => 'work_header']);
            $this->addMenuItem($workMenu, ['route' => 'work_show', 'rp' => $work->getRP()]);
            $this->addMenuItem($workMenu, ['route' => 'work_edit', 'rp' => $work->getRP()]);

        }

        // ...
    }

    public static function getSubscribedEvents()
    {
        return [
            KnpMenuEvent::class => 'onKnpMenuEvent',
        ];
    }
}
