<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
            'email' => 'bikcodeh@gmail.com',
            'username' => 'Bikcodeh',
            'first_name' => 'Victor',
            'last_name' => 'Hoyos',
            'role' => 'admin'
        ]);
    }
}
