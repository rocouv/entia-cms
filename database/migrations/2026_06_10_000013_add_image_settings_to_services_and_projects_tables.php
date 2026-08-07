<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table): void {
            $table->json('image_settings')->nullable()->after('image_path');
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->json('image_settings')->nullable()->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table): void {
            $table->dropColumn('image_settings');
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->dropColumn('image_settings');
        });
    }
};
