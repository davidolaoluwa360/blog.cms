<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where("email", "superAdmin@test.com")->first();
        if(!$user){
            $user = new User([
                'name' => "superAdmin",
                "email" => "superAdmin@test.com",
                "role" => "admin",
                "password" => bcrypt("superadmin123")
            ]);

            $user->save();
        }


    }
}
