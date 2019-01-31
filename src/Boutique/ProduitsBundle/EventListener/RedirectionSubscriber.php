<?php

namespace Boutique\ProduitsBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;


class RedirectionSubscriber implements EventSubscriberInterface
{

    private $router;
    private $routes;
    private $langs;
    private $locale;

    public function __construct(RouterInterface $router, array $languesSupportees, $locale)
    {
        $this->router = $router;
        $this->routes = $router->getRouteCollection();
        $this->langs = $languesSupportees;
        $this->locale = $locale;
    }

    public function isLocaleSupported($userLang)
    {
        return in_array($userLang, $this->langs);
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $userLang = $event->getRequest()->getPreferredLanguage();
        $actualPath = $event->getRequest()->getPathInfo();
        //$actualPath = substr($actualPath,3);
        $x = substr($userLang, 0, -3);
//        dump('path actuel ' . $actualPath);
//        dump('user lang ' . $userLang);
        $routeParams = $request->attributes->get('_locale');
//        dump('route param : ' . $routeParams);
        if ($this->isLocaleSupported($routeParams) == false) {
            $routeExists = false;
            foreach ($this->routes as $laRoute) {
                if ("/{_locale}" . $actualPath == $laRoute->getPath()) {
                    $routeExists = true;
                    break;
                }
            }
//            dump($routeExists);

            if ($routeExists) {
                if ( $this->isLocaleSupported($x) == false
                    || ($actualPath == "/" && $this->isLocaleSupported($x) == false))  {
                    $x = $this->locale;
                }
//                die("");
                $event->setResponse(new RedirectResponse("/" . $x . $actualPath));
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            'kernel.request' => array(array('onKernelRequest', 17))
        );
    }
}


