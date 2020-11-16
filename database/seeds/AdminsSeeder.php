<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'email' => 'superadmin@test.com', 
                'password' => Hash::make('password'), 
                'name' => 'Superadmin'
            ]
        ];
        foreach ($data as $item) {
            Admin::create($item);
        }
        Admin::find(1)->assignRole('super-admin');
    }
}
