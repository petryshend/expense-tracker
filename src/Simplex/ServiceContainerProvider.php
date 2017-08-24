<?php

namespace Simplex;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceContainerProvider
{
    private static $serviceContainer;

    public static function getServiceContainer(): ContainerInterface
    {
        if (isset(self::$serviceContainer)) {
            return self::$serviceContainer;
        }
        self::$serviceContainer = include __DIR__ . '/../../app/container.php';
        return self::$serviceContainer;
    }
}