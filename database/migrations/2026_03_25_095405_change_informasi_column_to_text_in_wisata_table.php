<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wisata', function (Blueprint $table) {
            $table->text('informasi')->change();
            $table->text('detail')->nullable()->change();
            $table->text('syarat')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('wisata', function (Blueprint $table) {
            $table->string('informasi')->change();
            $table->string('detail')->nullable()->change();
            $table->string('syarat')->nullable()->change();
        });
    }
};
