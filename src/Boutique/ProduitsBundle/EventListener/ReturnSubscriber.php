<?php

namespace  Boutique\ProduitsBundle\EventListener ;

use FOS\UserBundle\Event\UserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;

class ReturnSubscriber implements EventSubscriberInterface {

    private $router ;
    private $container ;
    private $eventDispatcher ;

    public function __construct(RouterInterface $router, $container, $eventDispatcher)
    {
        $this->router = $router ;
        $this->container = $container ;
        $this->eventDispatcher = $eventDispatcher ;
        dump(__METHOD__);
    }

    public function onImplicitLogin( $event)
    {
        dump($event);
        $token = $this->container->get('security.token_storage')->getToken();
        $user = null ;
        if ( $token )
            $user = $token->getUser();

        dump( $token, $user );
        dump($token instanceof AnonymousToken );
//        die(__METHOD__);
        if ( $this->container->get('security.token_storage')->getToken() ){
            dump( $event->getRequest() );
            $url = $event->getRequest()->headers->get('referer');
            echo "<br/>url : ".$url ;
           // die("on vient de se connecter");
            //$event->setResponse(new RedirectResponse($url));
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            'kernel.response' => array('onImplicitLogin', 1)
        );
    }
}
