<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\PurchaseOrder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseOrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $orders = PurchaseOrder::pluck('id', 'code');
        $materials = Material::pluck('id', 'sku');

        $items = [
            ['order_code' => 'PO-001', 'material_sku' => 'MAT-001', 'qty' => 200, 'price' => 60000],
            ['order_code' => 'PO-001', 'material_sku' => 'MAT-002', 'qty' => 1000, 'price' => 75000],
            ['order_code' => 'PO-001', 'material_sku' => 'MAT-003', 'qty' => 150, 'price' => 250000],
            ['order_code' => 'PO-002', 'material_sku' => 'MAT-004', 'qty' => 20, 'price' => 15000],
            ['order_code' => 'PO-003', 'material_sku' => 'MAT-005', 'qty' => 80, 'price' => 50000],
            ['order_code' => 'PO-004', 'material_sku' => 'MAT-006', 'qty' => 50, 'price' => 120000],
            ['order_code' => 'PO-004', 'material_sku' => 'MAT-009', 'qty' => 40, 'price' => 150000],
            ['order_code' => 'PO-005', 'material_sku' => 'MAT-003', 'qty' => 100, 'price' => 250000],
            ['order_code' => 'PO-005', 'material_sku' => 'MAT-008', 'qty' => 15, 'price' => 400000],
        ];

        foreach ($items as $item) {
            $orderId = $orders[$item['order_code']] ?? null;
            $materialId = $materials[$item['material_sku']] ?? null;

            if (! $orderId || ! $materialId) {
                continue;
            }

            $attributes = [
                'purchase_order_id' => $orderId,
                'material_id' => $materialId,
            ];

            $values = [
                'qty' => $item['qty'],
                'price' => $item['price'],
                'subtotal' => $item['qty'] * $item['price'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('purchase_order_items')->updateOrInsert($attributes, $values);
        }
    }
}
