<?php

use Phinx\Seed\AbstractSeed;

class ExpensesSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'title' => $faker->text(50),
                'amount' => $faker->randomFloat(2, 10, 1000),
                'created_at' => $faker->date('Y-m-d H:i:s')
            ];
        }
        $expenses = $this->table('expenses');
        $expenses->insert($data)
            ->save();
    }
}
