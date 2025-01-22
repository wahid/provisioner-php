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
        Schema::create('mailboxes', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->boolean('is_licensed')->default(false);
            $table->boolean('is_mailbox_delegated')->default(false);
            $table->boolean('is_calendar_delegated')->default(false);
            $table->boolean('is_calendar_named')->default(false);
            $table->boolean('is_created')->default(false);
            $table->boolean('is_grouped')->default(false);
            $table->boolean('is_send_alias_created')->default(false);
            $table->boolean('is_password_reset')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mailboxes');
    }
};
