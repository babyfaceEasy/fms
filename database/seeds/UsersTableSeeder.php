<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'admin admin',
            'email'=> 'admin@admin.com',
            'password'=> bcrypt("administrator"),
            'region' => 'lagos',
            'role' => 'na',
            'phone_number' => '08055613546',
        ]);
    }
}
