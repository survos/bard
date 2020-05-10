<?php

namespace App\EventSubscriber;

use App\Entity\Character;
use App\Entity\Work;

use Survos\LandingBundle\Traits\KnpMenuHelperTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;

class KnpTopMenuSubscriber implements EventSubscriberInterface
{
    use KnpMenuHelperTrait;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Security|AuthorizationCheckerInterface
     */
    private $security;

    /**
     * @param AuthorizationCheckerInterface $security
     */
    public function __construct(Security $security, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->security = $security;
    }

    private function isGranted(string $attribute, $subject=null) {
        return $this->security->isGranted($attribute, $subject);
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
            if ($this->isGranted('WORK_ADMIN', $work)) {
                $this->addMenuItem($workMenu, ['route' => 'work_edit', 'rp' => $work]);
            }
            $this->addMenuItem($workMenu, ['route' => 'work_slideshow', 'rp' => $work]);
            $this->addMenuItem($workMenu, ['route' => 'work_actions', 'rp' => $work]);
            // if I'm a team admin, then I can produce this
            $this->addMenuItem($workMenu, ['route' => 'work_produce', 'rp' => $work]);

        }

        /** @var Character $character */
        if ($character = $request->get('character')) {
            // $scriptMenu = $this->addMenuItem($menu, ['menu_code' => $script->getSlug(), 'label' => 'Script: ' . $script->getTitle()]);
            $this->addMenuItem($menu, ['route' => 'character_show', 'rp' => $character]);
            $this->addMenuItem($menu, ['route' => 'character_scenes', 'rp' => $character]);
            $this->addMenuItem($menu, ['route' => 'character_edit', 'rp' => $character]);
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $menu->addChild('ez', ['route' => 'easyadmin']);
            $menu->addChild('files', ['route' => 'admin_list_scripts', 'label' => 'Files'])->setAttribute('icon', 'fa fa-file-code');
            $menu->addChild('dropbox', ['route' => 'app_dropbox', 'label' => 'DropBox'])->setAttribute('icon', 'fab fa-dropbox');
        }

    }

    public static function getSubscribedEvents()
    {
        return [
            'topMenuEvent' => 'onKnpTopMenuEvent'
        ];
    }
}
