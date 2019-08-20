<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!$user = User::where('admin', true)->where('email', 'admin@email.com')->first())
        {
            $user = new User();
        }

        $user->username = 'admin';
        $user->email = 'admin@email.com';
        $user->password = bcrypt(123456);
        $user->email_verified_at = Carbon::now();
        $user->admin = true;
        $user->save();
    }
}
