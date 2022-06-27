<?php
// namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model; // <- added this

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(PaymentTypesTable::class);
        $this->call([
          UsersTableSeeder::class,
          RolesSeeder::class,
          PermissionSeeder::class,
          PaymentTypeSeeder::class,

        ]);
    }
}
