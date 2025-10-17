<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('projects')->insert([
            [
                'code' => 'PRJ-001',
                'name' => 'Pembangunan Gedung Kantor Desa Sungai Andai',
                'client' => 'Dinas Pekerjaan Umum dan Penataan Ruang',
                'location' => 'Jl. Sungai Andai, Banjarmasin Utara',
                'start_date' => '2025-01-15',
                'end_date' => '2025-06-30',
                'budget' => 1200000000.00,
                'status' => 'ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PRJ-002',
                'name' => 'Renovasi Jembatan Trans Kalimantan',
                'client' => 'Balai Pelaksanaan Jalan Nasional Kalsel',
                'location' => 'Kabupaten Barito Kuala',
                'start_date' => '2025-03-01',
                'end_date' => '2025-12-15',
                'budget' => 3400000000.00,
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PRJ-003',
                'name' => 'Pembangunan Drainase Kawasan Handil Bakti',
                'client' => 'Pemerintah Kabupaten Barito Kuala',
                'location' => 'Handil Bakti, Alalak',
                'start_date' => '2025-02-10',
                'end_date' => '2025-09-25',
                'budget' => 850000000.00,
                'status' => 'ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PRJ-004',
                'name' => 'Rehabilitasi Gedung BPPMDDTT Banjarmasin',
                'client' => 'Kementerian Desa PDTT',
                'location' => 'Jl. A. Yani Km 5, Banjarmasin',
                'start_date' => '2024-09-01',
                'end_date' => '2025-02-28',
                'budget' => 1650000000.00,
                'status' => 'done',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PRJ-005',
                'name' => 'Pembangunan Rumah Dinas Pegawai BPPMDDTT',
                'client' => 'BPPMDDTT Banjarmasin',
                'location' => 'Komplek Agrabudi, Berangas Timur',
                'start_date' => '2025-04-10',
                'end_date' => '2025-08-30',
                'budget' => 980000000.00,
                'status' => 'planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
