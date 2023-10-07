<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {

        Schema::create('discount', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['percentage', 'fixed']);
            $table->foreignId('sale_id')->constrained('sales');
            $table->decimal('value');
            $table->timestamp('timestamp');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('discount');
    }
};
