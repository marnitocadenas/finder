<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) { $table->id(); $table->string('name')->unique(); $table->string('icon')->default('fa-box'); $table->timestamps(); });
        Schema::create('lost_items', function (Blueprint $table) { $table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete(); $table->string('title',150); $table->text('description'); $table->foreignId('category_id')->constrained()->restrictOnDelete(); $table->date('date_lost'); $table->string('location_lost'); $table->string('image')->nullable(); $table->enum('status',['lost','found','closed'])->default('lost')->index(); $table->timestamps(); $table->softDeletes(); });
        Schema::create('found_items', function (Blueprint $table) { $table->id(); $table->foreignId('staff_id')->constrained('users')->cascadeOnDelete(); $table->string('title',150); $table->text('description'); $table->foreignId('category_id')->constrained()->restrictOnDelete(); $table->date('date_found'); $table->string('location_found'); $table->string('image')->nullable(); $table->enum('status',['unclaimed','claimed','turned_over'])->default('unclaimed')->index(); $table->timestamps(); $table->softDeletes(); });
        Schema::create('claims', function (Blueprint $table) { $table->id(); $table->foreignId('student_id')->constrained('users')->cascadeOnDelete(); $table->foreignId('found_item_id')->constrained()->cascadeOnDelete(); $table->foreignId('lost_item_id')->nullable()->constrained()->nullOnDelete(); $table->enum('status',['pending','approved','rejected'])->default('pending')->index(); $table->text('claim_description'); $table->string('proof_image')->nullable(); $table->text('review_note')->nullable(); $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete(); $table->timestamp('reviewed_at')->nullable(); $table->timestamps(); });
        Schema::create('notifications', function (Blueprint $table) { $table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete(); $table->string('title'); $table->text('message'); $table->boolean('is_read')->default(false)->index(); $table->enum('type',['claim_update','match_alert','general'])->default('general'); $table->string('link')->nullable(); $table->timestamps(); });
        Schema::create('activity_logs', function (Blueprint $table) { $table->id(); $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); $table->string('action'); $table->string('target_type'); $table->unsignedBigInteger('target_id')->nullable(); $table->string('ip_address',45)->nullable(); $table->timestamps(); });
    }
    public function down(): void { Schema::dropIfExists('activity_logs'); Schema::dropIfExists('notifications'); Schema::dropIfExists('claims'); Schema::dropIfExists('found_items'); Schema::dropIfExists('lost_items'); Schema::dropIfExists('categories'); }
};
