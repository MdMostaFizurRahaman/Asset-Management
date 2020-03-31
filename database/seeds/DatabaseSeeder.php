<?php

use Illuminate\Database\Seeder;
use App\Admin;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
        $admin = Admin::where('email', 'admin@annanovas.com')->get();
        if ($admin->count() == 0) {
            $admin = Admin::updateOrCreate([
                'email' => 'admin@annanovas.com'
            ], [
                    'name' => 'Admin',
                    'role_id' => 1,
                    'email' => 'admin@annanovas.com',
                    'email_verified_at' => Carbon::now(),
                    'password' => bcrypt('111111'),
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );

            if ($admin->wasRecentlyCreated) {
                $admin->attachRole($admin->role_id);
            }
        }
    }
}
