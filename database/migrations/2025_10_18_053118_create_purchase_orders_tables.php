<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $t) {
            $t->id();
            $t->string('code')->unique();
            $t->foreignId('supplier_id')->constrained('suppliers');
            $t->foreignId('project_id')->nullable()->constrained('projects');
            $t->foreignId('material_request_id')->nullable()->constrained('material_requests');
            $t->date('order_date');
            $t->enum('status', ['draft', 'approved', 'partial', 'received', 'canceled'])->index();
            $t->decimal('total', 18, 2)->default(0);
            $t->foreignId('approved_by')->nullable()->constrained('users');
            $t->timestamp('approved_at')->nullable();
            $t->timestamps();
        });

        Schema::create('purchase_order_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('purchase_order_id')->constrained('purchase_orders')->cascadeOnDelete();
            $t->foreignId('material_id')->constrained('materials');
            $t->decimal('qty', 18, 2);
            $t->decimal('price', 18, 2);
            $t->decimal('subtotal', 18, 2)->index();
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
        Schema::dropIfExists('purchase_orders');
    }
};
