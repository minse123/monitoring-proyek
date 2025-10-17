<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            [
                'sku' => 'MAT-001',
                'name' => 'Semen Portland 50kg',
                'unit_symbol' => 'sak',
                'min_stock' => 50,
            ],
            [
                'sku' => 'MAT-002',
                'name' => 'Pasir Halus',
                'unit_symbol' => 'kg',
                'min_stock' => 500,
            ],
            [
                'sku' => 'MAT-003',
                'name' => 'Besi Beton Ø12mm',
                'unit_symbol' => 'btg',
                'min_stock' => 100,
            ],
            [
                'sku' => 'MAT-004',
                'name' => 'Kawat Bendrat',
                'unit_symbol' => 'kg',
                'min_stock' => 20,
            ],
            [
                'sku' => 'MAT-005',
                'name' => 'Pipa PVC 1 Inch',
                'unit_symbol' => 'btg',
                'min_stock' => 60,
            ],
            [
                'sku' => 'MAT-006',
                'name' => 'Cat Tembok 5 Liter',
                'unit_symbol' => 'L',
                'min_stock' => 30,
            ],
            [
                'sku' => 'MAT-007',
                'name' => 'Batu Bata Merah',
                'unit_symbol' => 'pcs',
                'min_stock' => 1000,
            ],
            [
                'sku' => 'MAT-008',
                'name' => 'Kabel NYA 1.5mm',
                'unit_symbol' => 'roll',
                'min_stock' => 10,
            ],
            [
                'sku' => 'MAT-009',
                'name' => 'Gypsum Board 9mm',
                'unit_symbol' => 'lbr',
                'min_stock' => 20,
            ],
            [
                'sku' => 'MAT-010',
                'name' => 'Paku 5cm',
                'unit_symbol' => 'kg',
                'min_stock' => 25,
            ],
        ];

        $unitIdsBySymbol = DB::table('units')->pluck('id', 'symbol');

        foreach ($materials as $material) {
            $unitId = $unitIdsBySymbol[$material['unit_symbol']] ?? null;

            if (! $unitId) {
                continue;
            }

            DB::table('materials')->updateOrInsert(
                ['sku' => $material['sku']],
                [
                    'name' => $material['name'],
                    'unit_id' => $unitId,
                    'min_stock' => $material['min_stock'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
