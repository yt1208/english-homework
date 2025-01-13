<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;



class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'be動詞', 'slug' => 'be-verbs'],
            ['name' => '一般動詞', 'slug' => 'general-verbs'],
            ['name' => '進行形', 'slug' => 'progressive-form'],
            ['name' => '疑問詞', 'slug' => 'question-words'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    
    }
}
