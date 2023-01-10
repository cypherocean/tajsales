<?php

namespace Database\Seeders;
use App\Models\User;
 

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class UserSeeder extends Seeder{

    public function run(){
        $data = [
            [
                'name' => 'Super Admin',
                'phone' => '9898989800',
                'email' => 'admin@admin.com'
            ],
            [
                'name' => 'Gajjar Mitul',
                'phone' => '8200242382',
                'email' => 'mitul@admin.com'
            ],
            [
                'name' => 'Mustan Sir',
                'phone' => '8160553161',
                'email' => 'mustan@admin.com'
            ],
            [
                'name' => 'HardIk Patel',
                'phone' => '8000080272',
                'email' => 'hardik@admin.com'
            ],
        ];
        
        foreach($data as $row){
            $user = User::create([
                'name' => $row['name'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'password' => bcrypt('Admin@123'),
                'photo' => 'user-icon.jpg',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ]);        
 
        }


        $file_to_upload = public_path().'/uploads/users/';
        if (!File::exists($file_to_upload))
            File::makeDirectory($file_to_upload, 0777, true, true);

        if(file_exists(public_path('/assets/images/users/profile-pic.jpg')) && !file_exists(public_path('/uploads/users/user-icon.jpg')) ){
            File::copy(public_path('/assets/images/users/profile-pic.jpg'), public_path('/uploads/users/user-icon.jpg'));
        }
    }
}