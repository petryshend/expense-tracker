<?php

namespace Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Expense\ExpenseType;
use Expense\Record;
use Faker\Factory;

class ExpenseFixturesLoader implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $types = array_values(ExpenseType::toArray());
            $type = $types[array_rand($types)];
            $record = new Record(new ExpenseType($type), $faker->randomFloat(2, 1, 100), $faker->text(50));
            $record->setCreatedAt($faker->dateTime());
            $manager->persist($record);
        }

        $manager->flush();
    }
}