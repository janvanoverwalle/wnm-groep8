<?php

namespace AppBundle\Listener;

use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginListener
{
    /** @var Router */
    protected $router;

    /** @var TokenStorage */
    protected $token;

    /** @var EventDispatcherInterface */
    protected $dispatcher;

    /** @var Logger */
    protected $logger;

    /** @var Session */
    protected $session;

    /**
     * @param Router $router
     * @param TokenStorage $token
     * @param EventDispatcherInterface $dispatcher
     * @param Logger $logger
     */
    public function __construct(Router $router, TokenStorage $token, EventDispatcherInterface $dispatcher, Logger $logger, Session $session)
    {
        $this->router       = $router;
        $this->token        = $token;
        $this->dispatcher   = $dispatcher;
        $this->logger       = $logger;
        $this->session      = $session;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $this->dispatcher->addListener(KernelEvents::RESPONSE, [$this, 'onKernelResponse']);
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $roles = $this->token->getToken()->getRoles();

        $rolesTab = array_map(function($role){
            return $role->getRole();
        }, $roles);

        $this->logger->info(var_export($rolesTab, true));

        if (in_array('ROLE_ADMIN', $rolesTab)) {
            $route = $this->router->generate('admin');
        } elseif (in_array('ROLE_COACH', $rolesTab)) {
            $route = $this->router->generate('coach');
        }
        else {
            $route = $this->router->generate('fos_user_security_logout');
            // TODO: doesn't work
            $this->session->getFlashBag()->add('warning', 'Only administrators or coaches can login');
            $this->session->save();
        }

        $event->getResponse()->headers->set('Location', $route);
    }
}