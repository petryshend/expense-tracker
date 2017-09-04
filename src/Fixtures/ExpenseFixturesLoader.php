<?php

namespace Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Expense\Record;
use Faker\Factory;

class ExpenseFixturesLoader implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $record = new Record($faker->text(50), $faker->randomFloat(2, 1, 100));
            $record->setCreatedAt($faker->dateTime());
            $manager->persist($record);
        }

        $manager->flush();
    }
}