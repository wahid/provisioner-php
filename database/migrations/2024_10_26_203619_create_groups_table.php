<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->index();
            $table->string('reserved_email')->nullable();
            $table->text('description');
            $table->string('group_code')->unique();
            $table->boolean('is_created')->default(false);
            $table->boolean('is_custom')->default(false);
            $table->boolean('should_be_synced')->default(true);
            $table->foreignIdFor(\App\Models\Mailbox::class)->nullable()->constrained()->nullOnDelete();
            $table->boolean('should_have_mailbox')->default(true);
            $table->boolean('needs_update')->default(false);
            $table->boolean('needs_update_settings')->default(true);
            $table->enum('access_policy', ['AUTOMATIC', 'MANUAL', 'PUBLIC', 'PRIVATE'])->default('AUTOMATIC');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
