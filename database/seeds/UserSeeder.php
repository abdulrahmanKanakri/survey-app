<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Abd',
            'email' => 'abd@dev.com',
            'password' => \Hash::make('123hamadi')
        ]);

        User::find(1)->assignRole('admin');
    }
}
