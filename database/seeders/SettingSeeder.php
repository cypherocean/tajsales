<?php

namespace Database\Seeders;
use App\Models\Setting;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SettingSeeder extends Seeder{
    public function run(){
        $general = [
            'SITE_TITLE' => 'Taj Sales', 
            'SITE_TITLE_SF' => 'TS', 
            'CONTACT_NUMBER' => '+91 99137 40441',
            'ALTERNATE_CONTACT_NUMBER' => '+91 97127 31131',
            'MAIN_CONTACT_NUMBER' => '+91 98253 56656',
            'CONTACT_EMAIL' => 'tajsales111@gmail.com',
            'MAIN_CONTACT_EMAIL' => 'info@tajsales.com',
            'CONTACT_ADDRESS' => 'Varun Industrial Area -1, Opp. Gopal Hotel, Near Giri Cargo Movers, Near maldhari fatak, Kothariya, Rajkot.',
            'MAIN_CONTACT_ADDRESS' => 'Varun Industrial Area -1, Opp. Gopal Hotel, Near Giri Cargo Movers, Near maldhari fatak, Kothariya, Rajkot.'
        ];

        foreach($general as $key => $value){
            Setting::create([
                'key' => $key,
                'value' => $value,
                'type' => 'general',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ]);
        }

        $smtp = [
            'MAIL_MAILER' => 'smtp',
            'MAIL_HOST' => 'mail.tajsales.com',
            'MAIL_PORT' => '26',
            'MAIL_USERNAME' => 'test@tajsales.com',
            'MAIL_PASSWORD' => 'Test@tajsales123',
            'MAIL_ENCRYPTION' => 'tls',
            'MAIL_FROM_ADDRESS' => 'test@tajsales.com',
            'MAIL_FROM_NAME' => 'Taj Sales'
        ];

        foreach($smtp as $key => $value){
            Setting::create([
                'key' => $key,
                'value' => $value,
                'type' => 'smtp',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ]);
        }

        $sms = [
            'SMS_NAME' => 'Taj Sales',
            'SMS_NUMBER' => '+91-8000080000'
        ];

        foreach($sms as $key => $value){
            Setting::create([
                'key' => $key,
                'value' => $value,
                'type' => 'sms',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ]);
        }

        $social = [
            'FACEBOOK' => 'www.facebook.com/tajSales',
            'INSTAGRAM' => 'www.instagram.com/tajSales',
            'YOUTUBE' => 'www.youtube.com/tajSales',
            'GOOGLE' => 'www.google.com/tajSales'
        ];

        foreach($social as $key => $value){
            Setting::create([
                'key' => $key,
                'value' => $value,
                'type' => 'social',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ]);
        }

        $logo = [
            'FEVICON' => 'fevicon.png',
            'LOGO' => 'logo.png',
            'SMALL_LOGO' => 'small_logo.png'
        ];

        foreach($logo as $key => $value){
            Setting::create([
                'key' => $key,
                'value' => $value,
                'type' => 'logo',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ]);
        }

        $folder_to_upload = public_path().'/uploads/logo/';

        if (!\File::exists($folder_to_upload)) {
            \File::makeDirectory($folder_to_upload, 0777, true, true);
        }

        if(file_exists(public_path('/dummy/fevicon.png')) && !file_exists(public_path('/uploads/logo/fevicon.png')) ){
            File::copy(public_path('/dummy/fevicon.png'), public_path('/uploads/logo/fevicon.png'));
        }

        if(file_exists(public_path('/dummy/logo.png')) && !file_exists(public_path('/uploads/logo/logo.png')) ){
            File::copy(public_path('/dummy/logo.png'), public_path('/uploads/logo/logo.png'));
        }

        if(file_exists(public_path('/dummy/small_logo.png')) && !file_exists(public_path('/uploads/logo/small_logo.png')) ){
            File::copy(public_path('/dummy/small_logo.png'), public_path('/uploads/logo/small_logo.png'));
        }
    }
}
