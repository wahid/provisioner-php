<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Types\Plugin;
return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plugins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('description')->nullable();
            $table->boolean('is_auto_activated')->default(false);
            $table->boolean('is_enabled')->default(false);
            $table->string('external_system_name')->nullable();
            $table->boolean('supports_authorization_profiles')->default(false);
            $table->enum('type', array_column(Plugin::cases(), 'value'))->default(Plugin::Generic->value);
            $table->json('config')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plugins');
    }
};
