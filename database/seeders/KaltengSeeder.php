<?php

namespace Database\Seeders;

use App\Models\NameData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaltengSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $province_kalteng_id = 62;
        $kabkot_kalteng = [
            6201 => [
                'Luas Wilayah' => 10759,
                'Populasi' => 288850,
                'SMA' => 28,
                'Lulusan SMA' => 0,
                'Universitas / Sederajat' => 4,
                'Lulusan S1' => 12473,
                'Pengangguran' => 6459,
            ],
            6202  => [
                'Luas Wilayah' => 16796,
                'Populasi' => 443033,
                'SMA' => 39,
                'Lulusan SMA' => 0,
                'Universitas / Sederajat' => 7,
                'Lulusan S1' => 14352,
                'Pengangguran' => 10133,
            ],
            6203 => [
                'Luas Wilayah' => 14999,
                'Populasi' => 416300,
                'SMA' => 38,
                'Lulusan SMA' => 0,
                'Universitas / Sederajat' => 4,
                'Lulusan S1' => 13211,
                'Pengangguran' => 8568,
            ],
            6204  => [
                'Luas Wilayah' => 8830,
                'Populasi' => 136856,
                'SMA' => 32,
                'Lulusan SMA' => 0,
                'Universitas / Sederajat' => 2,
                'Lulusan S1' => 6477,
                'Pengangguran' => 2964,
            ],
            6205  => [
                'Luas Wilayah' => 8300,
                'Populasi' => 158514,
                'SMA' => 20,
                'Lulusan SMA' => 0,
                'Universitas / Sederajat' => 3,
                'Lulusan S1' => 6825,
                'Pengangguran' => 4149,
            ],
            6206  => [
                'Luas Wilayah' => 3827,
                'Populasi' => 66118,
                'SMA' => 7,
                'Lulusan SMA' => 0,
                'Universitas / Sederajat' => 0,
                'Lulusan S1' => 2953,
                'Pengangguran' => 1770,
            ],
            6207  => [
                'Luas Wilayah' => 6414,
                'Populasi' => 112441,
                'SMA' => 13,
                'Lulusan SMA' => 0,
                'Universitas / Sederajat' => 1,
                'Lulusan S1' => 4244,
                'Pengangguran' => 1792,
            ],
            6208  => [
                'Luas Wilayah' => 16404,
                'Populasi' => 158282,
                'SMA' => 17,
                'Lulusan SMA' => 0,
                'Universitas / Sederajat' => 1,
                'Lulusan S1' => 4603,
                'Pengangguran' => 3159,
            ],
            6209  => [
                'Luas Wilayah' => 17500,
                'Populasi' => 179950,
                'SMA' => 28,
                'Lulusan SMA' => 0,
                'Universitas / Sederajat' => 1,
                'Lulusan S1' => 6120,
                'Pengangguran' => 4187,
            ],
            6210  => [
                'Luas Wilayah' => 8997,
                'Populasi' => 142925,
                'SMA' => 14,
                'Lulusan SMA' => 0,
                'Universitas / Sederajat' => 0,
                'Lulusan S1' => 5206,
                'Pengangguran' => 1517,
            ],
            6211  => [
                'Luas Wilayah' => 10805,
                'Populasi' => 132675,
                'SMA' => 8,
                'Lulusan SMA' => 0,
                'Universitas / Sederajat' => 0,
                'Lulusan S1' => 6072,
                'Pengangguran' => 2311,
            ],
            6212  => [
                'Luas Wilayah' => 3834,
                'Populasi' => 118021,
                'SMA' => 13,
                'Lulusan SMA' => 0,
                'Universitas / Sederajat' => 1,
                'Lulusan S1' => 6413,
                'Pengangguran' => 2350,
            ],
            6213  => [
                'Luas Wilayah' => 23700,
                'Populasi' => 120824,
                'SMA' => 8,
                'Lulusan SMA' => 0,
                'Universitas / Sederajat' => 0,
                'Lulusan S1' => 4325,
                'Pengangguran' => 1545,
            ],
            6271 => [
                'Luas Wilayah' => 2399,
                'Populasi' => 310182,
                'SMA' => 47,
                'Lulusan SMA' => 0,
                'Universitas / Sederajat' => 22,
                'Lulusan S1' => 32738,
                'Pengangguran' => 7727,
            ]
        ];

        $name_data = NameData::all();

        // $province_data = [];
        $regency_data = [];

        foreach ($kabkot_kalteng as $regency_id => $data) {
            foreach ($data as $name => $amount) {
                // Find the corresponding `name_data_id`
                $ns = $name_data->firstWhere('name', $name);

                if ($ns) {
                    $regency_data[] = [
                        'year' => 2024,
                        'name_data_id' => $ns->id,
                        'regency_id' => $regency_id,
                        'amount' => $amount,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // DB::table('province_data')->insert([]);
        DB::table('regency_data')->insert($regency_data);
    }
}
