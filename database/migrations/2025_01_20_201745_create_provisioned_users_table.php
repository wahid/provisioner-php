<?php

use App\Types\UserActivationType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('provisioned_users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->string('full_user_id')->nullable();
            $table->string('person_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('upn')->nullable();
            $table->string('external_email')->nullable();
            $table->dateTime('employment_start_date');
            $table->dateTime('employment_end_date')->nullable();
            $table->string('big_number')->nullable();
            $table->string('agb_code')->nullable();
            $table->string('employer_code')->nullable();
            $table->boolean('is_non_salaried')->default(false);
            $table->string('private_number')->nullable();
            $table->string('private_email')->nullable();
            $table->string('email')->nullable();
            $table->string('reserved_email')->nullable();
            $table->boolean('should_have_license')->default(true);
            $table->boolean('should_be_synced')->default(true);
            $table->boolean('needs_signature_update')->default(false);
            $table->boolean('is_licensed')->default(false);
            $table->boolean('is_blocked')->default(false);
            $table->boolean('is_custom')->default(false);
            $table->boolean('should_include_in_global_address_list')->default(true);
            $table->enum('account_activation_policy', array_column(UserActivationType::cases(), 'value'))
                ->default(UserActivationType::Default ->value);
            $table->boolean('should_ignore_contracts')->default(false);
            $table->boolean('should_sync_back_to_data_provider')->default(true);
            $table->timestamps();
            $table->dateTime('members_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provisioned_users');
    }
};
