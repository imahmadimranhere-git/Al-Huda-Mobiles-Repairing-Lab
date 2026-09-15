<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'site_logo' => '',
            'hero_eyebrow' => 'Precision mobile diagnostics',
            'hero_heading' => "We fix what your phone can't tell you is wrong.",
            'hero_description' => "Micro-soldering, motherboard repair and full diagnostics, done by trained technicians and tracked from the moment it reaches our bench to the moment it's back in your hand.",
            'hero_button_text' => 'Book a repair',
            'hero_button_url' => '/book-repair',
            'contact_phone' => '',
            'contact_whatsapp' => '',
            'contact_email' => '',
            'contact_address' => '',
            'admin_whatsapp_number' => '+923335822910',
            'delivery_disclaimer' => "By confirming, I acknowledge that I have received my device back in working condition (or as described by the technician). Al Huda Mobiles Repairing Lab is not responsible for any damage, data loss, or device failure occurring after this confirmation, including but not limited to complete device failure ('dead' devices) arising from pre-existing conditions, misuse, or events beyond our control after handover.",
        ];

        foreach ($defaults as $key => $value) {
            SiteSetting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}