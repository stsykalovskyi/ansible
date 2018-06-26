<?php

namespace {{ project_name|title }}\AdminBundle\Services;

use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use {{ project_name|title }}\AdminBundle\Model\MenuItemModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class AdminMenuItemsListener
 * @package {{ project_name|title }}\AdminBundle\Services
 */
class AdminMenuItemsListener
{
    /** @var  AuthorizationChecker */
    private $authChecker;
    private $translator;

    public function __construct(AuthorizationChecker $authorizationChecker, TranslatorInterface $translator)
    {
        $this->authChecker = $authorizationChecker;
        $this->translator = $translator;
    }

    public function onSetupMenu(SidebarMenuEvent $event)
    {

        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }
    }

    protected function getMenu(Request $request)
    {
        $menuItems = [];

        $items = new MenuItemModel(
            'homepage',
            'Site home page',
            '{{ project_name }}_{{ core_bundle_name|lower }}_homepage',
            [],
            'fa fa-home'
        );

        $menuItems[] = $items;

//        if ($this->authChecker->isGranted('ROLE_SUPER_ADMIN')) {
//        }

        return $this->activateByRoute($request->get('_route'), $menuItems);
    }

    protected function activateByRoute($route, $items)
    {
        /** @var MenuItemModel $item */
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } else {
                if ($item->getRoute() == $route) {
                    $item->setIsActive(true);
                }
            }
        }

        return $items;
    }
}
