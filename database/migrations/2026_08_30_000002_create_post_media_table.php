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
        Schema::create('post_media', function (Blueprint $table) {
            $table->id();

            $table->foreignId('scheduled_post_id')
                ->constrained('scheduled_posts')
                ->cascadeOnDelete();

            $table->string('media_type'); // image, video
            $table->string('file_path');
            $table->string('file_name');
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');

            $table->string('caption')->nullable();
            $table->integer('order')->default(0);

            // Platform-specific media IDs after publishing
            $table->string('platform_media_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_media');
    }
};
