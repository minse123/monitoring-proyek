<?php

namespace Database\Seeders;

use App\Models\MaterialRequest;
use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::pluck('id', 'name');
        $projects = Project::pluck('id', 'code');
        $requests = MaterialRequest::pluck('id', 'code');
        $adminId = User::where('email', 'admin@example.com')->value('id');

        $orders = [
            [
                'code' => 'PO-001',
                'supplier_name' => 'PT. Borneo Konstruksi Mandiri',
                'project_code' => 'PRJ-001',
                'material_request_code' => 'MRQ-001',
                'order_date' => '2025-02-18',
                'status' => 'approved',
                'total' => 125000000.00,
                'approved_at' => '2025-02-19 09:00:00',
            ],
            [
                'code' => 'PO-002',
                'supplier_name' => 'CV. Kalimantan Bangun Sejahtera',
                'project_code' => 'PRJ-002',
                'material_request_code' => 'MRQ-002',
                'order_date' => '2025-03-15',
                'status' => 'draft',
                'total' => 0,
                'approved_at' => null,
            ],
            [
                'code' => 'PO-003',
                'supplier_name' => 'UD. Cahaya Teknik',
                'project_code' => 'PRJ-003',
                'material_request_code' => 'MRQ-003',
                'order_date' => '2025-03-25',
                'status' => 'canceled',
                'total' => 45000000.00,
                'approved_at' => '2025-03-26 08:30:00',
            ],
            [
                'code' => 'PO-004',
                'supplier_name' => 'PT. Sumber Material Nusantara',
                'project_code' => 'PRJ-004',
                'material_request_code' => null,
                'order_date' => '2025-04-10',
                'status' => 'received',
                'total' => 65000000.00,
                'approved_at' => '2025-04-11 10:15:00',
            ],
            [
                'code' => 'PO-005',
                'supplier_name' => 'CV. Mega Baja',
                'project_code' => 'PRJ-005',
                'material_request_code' => 'MRQ-005',
                'order_date' => '2025-05-10',
                'status' => 'partial',
                'total' => 89000000.00,
                'approved_at' => '2025-05-11 14:45:00',
            ],
        ];

        foreach ($orders as $order) {
            $supplierId = $suppliers[$order['supplier_name']] ?? null;
            $projectId = $projects[$order['project_code']] ?? null;
            $materialRequestId = $order['material_request_code']
                ? ($requests[$order['material_request_code']] ?? null)
                : null;

            if (! $supplierId || ! $projectId) {
                continue;
            }

            $attributes = ['code' => $order['code']];

            $values = [
                'supplier_id' => $supplierId,
                'project_id' => $projectId,
                'material_request_id' => $materialRequestId,
                'order_date' => $order['order_date'],
                'status' => $order['status'],
                'total' => $order['total'],
                'approved_by' => $order['approved_at'] ? $adminId : null,
                'approved_at' => $order['approved_at'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            PurchaseOrder::updateOrCreate($attributes, $values);
        }
    }
}
