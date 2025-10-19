<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('goods_receipts', function (Blueprint $t) {
            $t->id();
            $t->string('code')->unique();
            $t->foreignId('purchase_order_id')->constrained('purchase_orders');
            $t->date('received_date');
            $t->foreignId('received_by')->constrained('users');
            $t->text('remarks')->nullable();
            $t->timestamps();
        });

        Schema::create('goods_receipt_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('goods_receipt_id')->constrained('goods_receipts')->cascadeOnDelete();
            $t->foreignId('material_id')->constrained('materials');
            $t->decimal('qty', 18, 2);
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('goods_receipt_items');
        Schema::dropIfExists('goods_receipts');
    }
};
