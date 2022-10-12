<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345'),
        ]);

        Task::create([
            'title' => 'Project Assignment Fundamental',
            'description' => 'Database MongoDB and Object Oriented Programming',
            'is_done' => true,
        ]);

        Task::create([
            'title' => 'Project Assignment Intermediate',
            'description' => 'API and Service Repository Pattern',
            'is_done' => true,
        ]);

        Task::create([
            'title' => 'Project Assignment Advance',
            'description' => 'Implementation of API with Service Repository Pattern and JWT',
            'is_done' => false,
        ]);
    }
}
