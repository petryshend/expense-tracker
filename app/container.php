<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Simplex\Framework;
use Simplex\UserListener;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

function getConfigKeys(array $array, $keyName = '')
{
    if ($keyName !== '') {
        $keyName .= '.';
    }
    $res = [];
    foreach ($array as $key => $val) {
        if (!is_array($val)) {
            $res[$keyName . $key] = $val;
        } else {
            $res = array_merge($res, getConfigKeys($val, $keyName . $key));
        }
    }
    return $res;
}

$sc = new ContainerBuilder();
$config = getConfigKeys(require 'config.php');
$routes = require 'routes.php';

foreach ($config as $key => $val) {
    $sc->setParameter($key, $val);
}

$sc->register('context', RequestContext::class);

$sc->register('url.generator', UrlGenerator::class)
    ->setArguments([$routes, new Reference('context')])
;

$sc->register('matcher', UrlMatcher::class)
    ->setArguments(array($routes, new Reference('context')))
;

$sc->register('request_stack', RequestStack::class);

$sc->register('controller_resolver', ControllerResolver::class);

$sc->register('argument_resolver', ArgumentResolver::class);


$sc->register('listener.router', RouterListener::class)
    ->setArguments(array(new Reference('matcher'), new Reference('request_stack')))
;

$sc->register('listener.response', ResponseListener::class)
    ->setArguments(array('UTF-8'))
;

$sc->register('listener.user', UserListener::class);

$sc->register('dispatcher', EventDispatcher::class)
    ->addMethodCall('addSubscriber', [new Reference('listener.router')])
    ->addMethodCall('addSubscriber', [new Reference('listener.response')])
    ->addMethodCall('addSubscriber', [new Reference('listener.user')])
;

$sc->register('framework', Framework::class)
    ->setArguments(array(
        new Reference('dispatcher'),
        new Reference('controller_resolver'),
        new Reference('request_stack'),
        new Reference('argument_resolver'),
    ))
;

$sc->register('twig', Twig_Environment::class)
    ->setArguments([new Twig_Loader_Filesystem(__DIR__ . '/../src/templates')]);

$sc->register('entity.manager', EntityManager::class)
    ->setArguments([
        [
            'driver' => 'pdo_' . $sc->getParameter('db.driver'),
            'user' => $sc->getParameter('db.username'),
            'password' => $sc->getParameter('db.password'),
            'host' => $sc->getParameter('db.host'),
            'port' => $sc->getParameter('db.port'),
            'dbname' => $sc->getParameter('db.dbname'),
        ],
        Setup::createAnnotationMetadataConfiguration([__DIR__ . '/../src'], true)
    ])
    ->setFactory([EntityManager::class, 'create']);

return $sc;