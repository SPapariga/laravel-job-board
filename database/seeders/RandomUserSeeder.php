<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class RandomUserSeeder extends Seeder
{

    public function run(): void
    {
        $users=User::factory(10)->create();
        echo "Users created successfully";
    }
}
