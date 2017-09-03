<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Simplex\ServiceContainerProvider;

require __DIR__ . '/vendor/autoload.php';

$serviceContainer = ServiceContainerProvider::getServiceContainer();
/** @var EntityManager $entityManager */
$entityManager = $serviceContainer->get('entity.manager');

return ConsoleRunner::createHelperSet($entityManager);