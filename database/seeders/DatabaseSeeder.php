<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
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
        // DB::table('users')->delete();
        $this->call(UserSeeder::class);
        // $this->call(AdminSeeder::class);
        $this->call(RolePermissionSeeder::class);
        // DB::table('users')->insert(
        //     // [
        //     //     'name' => 'nirmit',
        //     //     'email' => Str::random(10).'@gmail.com',
        //     //     'password' => Hash::make('password'),
        //     // ],
        //     // [
        //     //     'name' => 'nilesh',
        //     //     'email' => Str::random(10).'@gmail.com',
        //     //     'password' => Hash::make('password'),
        //     // ],
            
        // );
        // $users = [
        //     ['name' => 'KhushAL', 'email' => 'stephan-v@gmail.com', 'password' => bcrypt('carrotz124')],
        //     ['name' => 'nilesh', 'email' => 'johndoe@gmail.com', 'password' => bcrypt('carrotz1243')],
        //     ['name' => 'Khyati', 'email' => 'johnasddoe@gmail.com', 'password' => bcrypt('carrotz12sd')],
        //     ['name' => 'hardik', 'email' => 'johnasdsddoe@gmail.com', 'password' => bcrypt('carrotz12sdfsd')],

        // ];
        // DB::table('users')->insert($users);
        // // foreach($users as $user){
        // //     User::create($user);
        // // }
    }
}
