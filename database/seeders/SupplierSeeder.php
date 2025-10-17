<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('suppliers')->insert([
            [
                'name' => 'PT. Borneo Konstruksi Mandiri',
                'npwp' => '09.234.567.8-987.000',
                'email' => 'info@borneokonstruksi.co.id',
                'phone' => '081234567890',
                'address' => 'Jl. A. Yani KM 4,5 No. 12, Banjarmasin',
                'rating' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CV. Kalimantan Bangun Sejahtera',
                'npwp' => '31.456.789.0-123.000',
                'email' => 'contact@kalbangun.com',
                'phone' => '081345678901',
                'address' => 'Jl. Perintis Kemerdekaan No. 45, Banjarbaru',
                'rating' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'UD. Cahaya Teknik',
                'npwp' => null,
                'email' => 'cahaya.teknik@gmail.com',
                'phone' => '082156789012',
                'address' => 'Jl. Veteran, Banjarmasin Timur',
                'rating' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PT. Sumber Material Nusantara',
                'npwp' => '02.111.222.3-999.000',
                'email' => 'sales@sumbermaterial.id',
                'phone' => '081278945612',
                'address' => 'Jl. Trans Kalimantan KM 12, Barito Kuala',
                'rating' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CV. Mega Baja',
                'npwp' => '55.666.777.8-101.000',
                'email' => 'megabaja@yahoo.com',
                'phone' => '085177889900',
                'address' => 'Jl. MT Haryono No. 88, Banjarmasin Tengah',
                'rating' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
