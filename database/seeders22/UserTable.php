<?php

use Illuminate\Database\Seeder;

class UserTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::where('email', 'bernaldezsay@gmail.com')->first();

        if(!$user)
        {
            User::create([
                'first_name' => 'Charles',
                'last_name' => 'Andrew',
                'email' => 'bernaldezsay@gmail.com',
                'role' => 1,
                'password' => Hash::make('password') //security purposes
            ]);
        }
    }
}
