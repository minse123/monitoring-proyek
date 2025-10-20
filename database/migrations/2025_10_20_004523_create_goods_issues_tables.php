<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('goods_issues', function (Blueprint $t) {
            $t->id();
            $t->string('code')->unique();
            $t->foreignId('project_id')->constrained('projects');
            $t->date('issued_date')->index();
            $t->enum('status', ['draft', 'issued', 'returned'])->default('draft')->index();
            $t->foreignId('issued_by')->constrained('users');
            $t->text('remarks')->nullable();
            $t->timestamps();
        });

        Schema::create('goods_issue_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('goods_issue_id')->constrained('goods_issues')->cascadeOnDelete();
            $t->foreignId('material_id')->constrained('materials');
            $t->decimal('qty', 18, 2);
            $t->string('remarks', 255)->nullable();
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('goods_issue_items');
        Schema::dropIfExists('goods_issues');
    }
};
