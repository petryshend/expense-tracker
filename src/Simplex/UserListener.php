<?php

namespace Simplex;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGenerator;

class UserListener implements EventSubscriberInterface
{
    public function onRequest(GetResponseEvent $event)
    {
        $container = ServiceContainerProvider::getServiceContainer();
        /** @var UrlGenerator $urlGenerator */
        $urlGenerator = $container->get('url.generator');
        $loginPath = $urlGenerator->generate('login');
        $currentPath = $event->getRequest()->getPathInfo();

        if ($currentPath === $loginPath) {
            return;
        }

        if (!isset($_SESSION['username'])) {
            $response = new RedirectResponse($loginPath);
            $event->setResponse($response);
        }
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::REQUEST => ['onRequest', 0]];
    }
}