<?php

namespace Database\Seeders;

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
        $newAdmin = new \App\Models\User;
        $newAdmin->name = 'ADMIN';
        $newAdmin->username = 'admin';
        $newAdmin->password = \Hash::make('123456');
        $newAdmin->profile_photo = 'upload/admin/admin/20210610144813user.png';
        $newAdmin->save();
    }
}
