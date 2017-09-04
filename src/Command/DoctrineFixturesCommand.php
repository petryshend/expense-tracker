<?php

namespace Command;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Fixtures\ExpenseFixturesLoader;
use Simplex\ServiceContainerProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DoctrineFixturesCommand extends Command
{
    protected function configure()
    {
        $this->setName('fixtures:apply')
            ->setDescription('Apply doctrine data fixtures');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loader = new Loader();

        $loader->addFixture(new ExpenseFixturesLoader());

        $entityManager = $this->getEntityManager();
        $purger = new ORMPurger();
        $executor = new ORMExecutor($entityManager, $purger);
        $executor->execute($loader->getFixtures());

        echo 'Fixtures applied' . PHP_EOL;
        return 0;
    }

    private function getEntityManager()
    {
        return ServiceContainerProvider::getServiceContainer()
            ->get('entity.manager');
    }
}