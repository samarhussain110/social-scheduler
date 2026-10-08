<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scheduled_posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('platform'); // facebook, instagram, linkedin
            $table->foreignId('social_account_id')
                ->nullable()
                ->constrained('social_accounts')
                ->nullOnDelete();

            $table->text('content');
            $table->string('status')->default('pending'); // pending, scheduled, publishing, published, failed, cancelled

            $table->dateTime('scheduled_at');
            $table->dateTime('published_at')->nullable();

            $table->string('timezone')->default('UTC');

            // API response tracking
            $table->string('platform_post_id')->nullable();
            $table->json('api_response')->nullable();
            $table->text('error_message')->nullable();

            // Retry logic
            $table->integer('retry_count')->default(0);
            $table->integer('max_retries')->default(3);
            $table->dateTime('next_retry_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_posts');
    }
};
