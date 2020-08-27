<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(config('app.env', 'local') === 'lokal') {
            $this->call(RolesSeeder::class);
            $this->call(PermissionsSeeder::class);
            $this->call(UsersSeeder::class);
            $this->call(WorkPermitSeeder::class);
            $this->call(PermissionHrdsSeeder::class);
        }
        //$this->call(OthersSeeder::class);
        //$this->call(WoSeeders::class);
    }
}
