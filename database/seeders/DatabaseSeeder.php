<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $actions = Action::factory(20)
            ->state(new Sequence(
                ['status' => 0],
                ['status' => 1],
                ['status' => 2],
                ['status' => 3],
            ))
            ->status()
            ->create();

        foreach ($actions as $action) {
            switch ($action->name) {
                case 'Eat breakfast':
                case 'Eat lunch':
                case 'Eat dinner':
                    $action->tags()->attach([1, 2]);
                    break;
                case 'Go to bed on time':
                    $action->tags()->attach(2);
                    break;
                case 'Play cellphone':
                    $action->tags()->attach(3);
                    break;
                case 'Running':
                case 'Aerobic exercise':
                    $action->tags()->attach(4);
                    break;
            }
        }
    }
}
