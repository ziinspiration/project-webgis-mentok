<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->char('id', 36)->change();
            $table->boolean('is_verified')->default(0)->nullable(false)->change();
            $table->boolean('is_allaccess')->default(0)->nullable(false)->change();
            $table->boolean('is_active')->default(1)->nullable(false)->change();
            $table->string('token', 255)->nullable(false)->change();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->char('id', 36)->change();
            $table->char('user_id', 36)->nullable(false)->change();
            $table->integer('sort_order')->nullable(false)->change();
        });

        Schema::table('map_data', function (Blueprint $table) {
            $table->char('id', 36)->change();
            $table->char('category_id', 36)->nullable(false)->change();
            $table->char('user_id', 36)->nullable(false)->change();
            $table->string('icon_path', 255)->nullable(false)->change();
            $table->integer('sort_order')->nullable(false)->change();
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->char('id', 36)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
