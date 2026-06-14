<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('brand')->nullable()->after('title');
            $table->decimal('discount', 10, 2)->nullable()->after('price');
            $table->string('discount_type')->default('fixed')->after('discount');
            $table->text('colors')->nullable()->after('size');
            $table->text('tags')->nullable()->after('colors');
            $table->string('visibility')->default('published')->after('tags');
            $table->date('publish_date')->nullable()->after('visibility');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'brand', 'discount', 'discount_type', 'colors', 'tags', 'visibility', 'publish_date'
            ]);
        });
    }
};
