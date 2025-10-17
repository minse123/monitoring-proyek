<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'Kilogram', 'symbol' => 'kg'],
            ['name' => 'Meter', 'symbol' => 'm'],
            ['name' => 'Lembar', 'symbol' => 'lbr'],
            ['name' => 'Liter', 'symbol' => 'L'],
            ['name' => 'Pcs', 'symbol' => 'pcs'],
            ['name' => 'Sak', 'symbol' => 'sak'],
            ['name' => 'Dus', 'symbol' => 'dus'],
            ['name' => 'Batang', 'symbol' => 'btg'],
            ['name' => 'Roll', 'symbol' => 'roll'],
        ];

        foreach ($units as $unit) {
            DB::table('units')->updateOrInsert(
                ['symbol' => $unit['symbol']],
                [
                    'name' => $unit['name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
