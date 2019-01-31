<?php

namespace  Boutique\ProduitsBundle\EventListener ;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ConnexionSubscriber implements EventSubscriberInterface
{
    private $router ;
    private $container ;

    public function __construct(RouterInterface $router,  $service)
    {
        $this->router= $router ;
        $this->container = $service ;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $actualRoute = $request->attributes->get('_route');
        //$token = $this->security->get('security.token_storage')->getToken();
        dump( $this->container->get('security.authorization_checker')
            ->isGranted('IS_AUTHENTICATED_FULLY') );
//        dump( $token->get('security.token_storage')->getToken() );
//        dump($token->isAuthenticated() );
        if ( $actualRoute == 'validate_cart'){
            // si l user n est pas connecté on le redirige vers login
            //$token = $this->security->getToken()->getUser();

            $user = null ;
            if ( $token )
                $user = $token->getUser();
            if ( !$token  || !$user ){
                $event->setResponse(new RedirectResponse( $this->router->generate('fos_user_security_login', array('_locale'=> "fr")) ));
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            'kernel.request' => array(array('onKernelRequest', 18))
        );
    }
}