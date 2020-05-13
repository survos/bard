<?php

/*
 * This file is part of the AdminLTE bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Menu;

use KevinPapst\AdminLTEBundle\Event\KnpMenuEvent;
use Knp\Menu\FactoryInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class TopMenuBuilder
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param FactoryInterface $factory
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(FactoryInterface $factory, EventDispatcherInterface $eventDispatcher)
    {
        $this->factory = $factory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function createTopMenu(array $options)
    {

        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => ['class' => 'nav navbar-nav navbar-sm'],
        ]);

        $childOptions = [
            'attributes' => ['class' => 'navbar-item'],
            'childrenAttributes' => ['class' => 'navbar-item'],
            'labelAttributes' => [],
        ];

        $this->eventDispatcher->dispatch(new KnpMenuEvent($menu, $this->factory, $options, $childOptions), 'topMenuEvent');


        return $menu;
    }
}
