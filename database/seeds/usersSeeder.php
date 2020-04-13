<?php

use Illuminate\Database\Seeder;

class usersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = bcrypt('admin123');

        $users_data=[ 

            ['id'=>'1',
            'name'=>'Super Admin',
            'email'=>'admin@thalamus.id',
            'password'=>$password,
            'akses'=>'0'],

            ['id'=>'2',
            'name'=>'Admin FasKes',
            'email'=>'admin1@thalamus.id',
            'password'=>$password,
            'akses'=>'1'],

            ['id'=>'3',
            'name'=>'Admin 0',
            'email'=>'admin2@thalamus.id',
            'password'=>$password,
            'akses'=>'1']

        ];
        DB::table('users')->insert($users_data);
    }
}