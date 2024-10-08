<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'الرياض', 'state_id' => 1],
            ['name' => 'جدة', 'state_id' => 2],
            ['name' => 'مكة المكرمة', 'state_id' => 2],
            ['name' => 'المدينة المنورة', 'state_id' => 3],
            ['name' => 'الدمام', 'state_id' => 4],
            ['name' => 'الخبر', 'state_id' => 4],
            ['name' => 'الظهران', 'state_id' => 4],
            ['name' => 'الطائف', 'state_id' => 2],
            ['name' => 'بريدة', 'state_id' => 5],
            ['name' => 'حائل', 'state_id' => 6],
            ['name' => 'أبها', 'state_id' => 7],
            ['name' => 'خميس مشيط', 'state_id' => 7],
            ['name' => 'جازان', 'state_id' => 8],
            ['name' => 'نجران', 'state_id' => 9],
            ['name' => 'تبوك', 'state_id' => 10],
            ['name' => 'عرعر', 'state_id' => 11],
            ['name' => 'سكاكا', 'state_id' => 12],
            ['name' => 'ينبع', 'state_id' => 3],
            ['name' => 'القنفذة', 'state_id' => 2],
            ['name' => 'الباحة', 'state_id' => 13],
            ['name' => 'بيشة', 'state_id' => 7],
            ['name' => 'الرس', 'state_id' => 5],
            ['name' => 'صبيا', 'state_id' => 8],
            ['name' => 'رابغ', 'state_id' => 2],
            ['name' => 'الجوف', 'state_id' => 12],
            ['name' => 'محايل عسير', 'state_id' => 7],
            ['name' => 'النماص', 'state_id' => 7],
            ['name' => 'القريات', 'state_id' => 12],
            ['name' => 'الحناكية', 'state_id' => 3],
            ['name' => 'ضبا', 'state_id' => 10],
            ['name' => 'أملج', 'state_id' => 10],
            ['name' => 'خليص', 'state_id' => 2],
            ['name' => 'المجاردة', 'state_id' => 7],
            ['name' => 'الخرج', 'state_id' => 1],
            ['name' => 'الدوادمي', 'state_id' => 1],
            ['name' => 'السليل', 'state_id' => 1],
            ['name' => 'الأفلاج', 'state_id' => 1],
            ['name' => 'حوطة بني تميم', 'state_id' => 1],
            ['name' => 'الحريق', 'state_id' => 1],
            ['name' => 'وادي الدواسر', 'state_id' => 1],
            ['name' => 'رنية', 'state_id' => 2],
            ['name' => 'المزاحمية', 'state_id' => 1],
            ['name' => 'العيينة', 'state_id' => 1],
            ['name' => 'ضرما', 'state_id' => 1],
            ['name' => 'حوطة سدير', 'state_id' => 1],
            ['name' => 'ثادق', 'state_id' => 1],
            ['name' => 'الزلفي', 'state_id' => 1],
            ['name' => 'شقراء', 'state_id' => 1],
            ['name' => 'الغاط', 'state_id' => 1],
            ['name' => 'المجمعة', 'state_id' => 1],
            ['name' => 'عفيف', 'state_id' => 1],
            ['name' => 'البدائع', 'state_id' => 5],
            ['name' => 'المذنب', 'state_id' => 5],
            ['name' => 'البكيرية', 'state_id' => 5],
            ['name' => 'رياض الخبراء', 'state_id' => 5],
            ['name' => 'النبهانية', 'state_id' => 5],
            ['name' => 'عيون الجواء', 'state_id' => 5],
            ['name' => 'الأسياح', 'state_id' => 5],
            ['name' => 'قبه', 'state_id' => 5],
            ['name' => 'الشماسية', 'state_id' => 5],
            ['name' => 'دومة الجندل', 'state_id' => 12],
            ['name' => 'طبرجل', 'state_id' => 12],
            ['name' => 'رفحاء', 'state_id' => 11],
            ['name' => 'طريف', 'state_id' => 11],
            ['name' => 'تربة', 'state_id' => 2],
            ['name' => 'الخرمة', 'state_id' => 2],
            ['name' => 'المويه', 'state_id' => 2],
            ['name' => 'الليث', 'state_id' => 2],
            ['name' => 'حلي', 'state_id' => 2],
            ['name' => 'المظيلف', 'state_id' => 2],
            ['name' => 'ثريبان', 'state_id' => 7],
            ['name' => 'البشائر', 'state_id' => 7],
            ['name' => 'الحرجة', 'state_id' => 7],
            ['name' => 'سراة عبيدة', 'state_id' => 7],
            ['name' => 'القرى', 'state_id' => 13],
            ['name' => 'المندق', 'state_id' => 13],
            ['name' => 'بلجرشي', 'state_id' => 13],
            ['name' => 'قلوة', 'state_id' => 13],
            ['name' => 'العقيق', 'state_id' => 13],
            ['name' => 'المخواة', 'state_id' => 13],
            ['name' => 'ثول', 'state_id' => 2],
            ['name' => 'بقيق', 'state_id' => 4],
            ['name' => 'القطيف', 'state_id' => 4],
            ['name' => 'سيهات', 'state_id' => 4],
            ['name' => 'عنك', 'state_id' => 4],
            ['name' => 'صفوى', 'state_id' => 4],
            ['name' => 'رأس تنورة', 'state_id' => 4],
            ['name' => 'حفر الباطن', 'state_id' => 4],
            ['name' => 'القيصومة', 'state_id' => 4],
            ['name' => 'النعيرية', 'state_id' => 4],
            ['name' => 'الخفجي', 'state_id' => 4],
            ['name' => 'قرية العليا', 'state_id' => 4],
            ['name' => 'الصرار', 'state_id' => 4],
            ['name' => 'العيون', 'state_id' => 4],
            ['name' => 'سلوى', 'state_id' => 4],
            ['name' => 'البطحاء', 'state_id' => 4],
            ['name' => 'القارة', 'state_id' => 4],
            ['name' => 'المبرز', 'state_id' => 4],
        ];

        foreach ($cities as &$city) {
            $city['slug'] = Str::slug($city['name']) . '-' . Str::random(5);
        }

        DB::table('cities')->insert($cities);    
    }
}