<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->text('services_description')->nullable();
            $table->text('projects_description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->dropColumn(['services_description', 'projects_description']);
        });
    }
};
