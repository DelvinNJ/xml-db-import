<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('entity_id')->unique();
            $table->string('category_name');
            $table->string('sku', 50)->unique();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->text('short_desc')->nullable();
            $table->decimal('price', 10, 4);
            $table->text('link');
            $table->text('image');
            $table->string('brand');
            $table->smallInteger('rating')->nullable();
            $table->string('caffeine_type', 50)->nullable();
            $table->integer('count')->nullable();
            $table->boolean('flavored')->default(false);
            $table->boolean('seasonal')->default(false);
            $table->boolean('in_stock')->default(true);
            $table->boolean('facebook')->default(false);
            $table->boolean('is_kcup')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
