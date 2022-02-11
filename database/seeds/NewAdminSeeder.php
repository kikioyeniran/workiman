<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class NewAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->username = 'workiman_admin';
        $user->email = 'workiman_admin@email.com';
        $user->password = bcrypt('Started!');
        $user->email_verified_at = Carbon::now();
        $user->admin = true;
        $user->save();
    }
}
