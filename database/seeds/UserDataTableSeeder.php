<?php

use Illuminate\Database\Seeder;

class UserDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\UserData::class, 30)->create();
    }
}
