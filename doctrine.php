#!/usr/bin/php
<?php

use Command\DoctrineFixturesCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\ORM\Version;
use Simplex\ServiceContainerProvider;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;

require __DIR__ . '/vendor/autoload.php';

$serviceContainer = ServiceContainerProvider::getServiceContainer();
/** @var EntityManager $entityManager */
$entityManager = $serviceContainer->get('entity.manager');

$cli = new Application('Doctrine command line interface', Version::VERSION);
$cli->setCatchExceptions(true);

$helperSet = new HelperSet([
    'db' => new ConnectionHelper($entityManager->getConnection()),
    'em' => new EntityManagerHelper($entityManager),
    'qe' => new QuestionHelper(),
]);

$cli->setHelperSet($helperSet);

$cli->addCommands([
    new DiffCommand(),
    new ExecuteCommand(),
    new GenerateCommand(),
    new MigrateCommand(),
    new StatusCommand(),
    new VersionCommand(),
    new DoctrineFixturesCommand(),
]);

ConsoleRunner::addCommands($cli);

$cli->run();