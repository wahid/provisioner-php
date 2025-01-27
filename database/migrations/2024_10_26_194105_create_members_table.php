<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Types\EntityType;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\ProvisionedUser::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(\App\Models\Group::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(\App\Models\MemberFunction::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->string('employment_number')->nullable();

            $table->string('role')->nullable();

            $table->string('subscription')->nullable();

            $table->timestamp('start_date');

            $table->timestamp('end_date')->nullable();

            $table->boolean('should_be_synced')->default(true);

            $table->boolean('should_calendar_be_enabled')->default(true);

            $table->enum('status', ['active', 'inactive'])->default('inactive');

            $table->enum('entity_type', array_column(EntityType::cases(), 'value'))
                ->default(EntityType::Default ->value);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
