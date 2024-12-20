<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NonSpasialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $general = Category::create([
            'name' => 'Umum',
        ]);

        $pendidikan = Category::create([
            'name' => 'Pendidikan',
        ]);

        $pekerjaan = Category::create([
            'name' => 'Pekerjaan',
        ]);

        DB::table('name_data')->insert([
            ['name' => 'Luas Wilayah', 'category_id' => $general->id],
            ['name' => 'Populasi', 'category_id' => $general->id],
            ['name' => 'SMA', 'category_id' => $pendidikan->id],
            ['name' => 'Lulusan SMA', 'category_id' => $pendidikan->id],
            ['name' => 'Universitas / Sederajat', 'category_id' => $pendidikan->id],
            ['name' => 'Lulusan S1', 'category_id' => $pendidikan->id],
            ['name' => 'Pengangguran', 'category_id' => $pekerjaan->id],
        ]);
    }
}
