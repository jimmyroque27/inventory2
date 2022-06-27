<?php
// namespace Database\Seeders;
use App\User;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
    //     $user = User::where('email', 'bernaldezsay@gmail.com')->first();
    //
    //     if(!$user)
    //     {
    //         User::create([
    //             'name' => 'Charles',
    //             'email' => 'bernaldezsay@gmail.com',
    //             'role' => 1,
    //             'password' => Hash::make('password') //security purposes
    //         ]);
    //     }
    // }

    public function run()
     {
         $users = [
           [
             'email'    => 'bernaldezsay@gmail.com',
             'name'     => 'Super Admin',
             'password' => Hash::make('password'),
             'role'     => 'admin'
           ],
           [
             'email'    => 'user@testmail.com',
             'name'     => 'Test User',
             'password' => Hash::make('12345678'),
             'role'     => 'user'
           ],
         ];

        $role = new Role;
         foreach ($users as $key => $user) {
           $newUser = User::updateOrCreate([
                        'email' => $user['email']
                    ], [
                        'name'     => $user['name'],
                        'password' => $user['password']
                    ]);

                    if ($newUser->id == 1) {
                        $role = $role->updateOrCreate(['name' => 'admin']);
                    } else {
                        $role = $role->updateOrCreate(['name' => 'user']);
                    }

                   $permissions = Permission::pluck('id')->toArray();

                   $role->syncPermissions($permissions);
                   $newUser->assignRole([$role->id]);
         }
     }
}
