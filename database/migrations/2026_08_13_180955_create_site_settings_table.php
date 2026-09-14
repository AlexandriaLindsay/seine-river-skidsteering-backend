<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('business_name')->default('Seine River Skidsteering');
            $table->string('tagline')->nullable();
            $table->text('about_text')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('service_area')->nullable();
            $table->string('hours')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};