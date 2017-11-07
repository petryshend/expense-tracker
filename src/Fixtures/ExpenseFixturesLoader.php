<?php

namespace Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Entity\Record;
use Entity\User;
use Expense\ExpenseType;
use Faker\Factory;

class ExpenseFixturesLoader implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $user = new User();
        $user->setEmail($faker->email);
        $user->setPassword('1');

        for ($i = 0; $i < 10; $i++) {
            $types = array_values(ExpenseType::toArray());
            $type = $types[array_rand($types)];
            $record = (new Record())
                ->setType($type)
                ->setAmount($faker->randomFloat(2, 1, 100))
                ->setComment($faker->text(50));
            $record->setUser($user);
            $user->addRecord($record);
            $manager->persist($record);
        }
        $manager->persist($user);

        $manager->flush();
    }
}