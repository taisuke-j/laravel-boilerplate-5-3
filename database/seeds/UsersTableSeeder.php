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

        $users = DB::select('select * from users');
        if (!count($users)) {

            DB::table('users')->insert([
                'name' => 'Admin',
                'email' => 'test1@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]);

            DB::table('users')->insert([
                'name' => 'Tom',
                'email' => 'test2@gmail.com',
                'password' => bcrypt('password'),
            ]);

        }
    }
}
