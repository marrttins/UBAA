<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cooperative_settings', function (Blueprint $table) {
            $table->string('heading')->nullable()->after('title');
            $table->text('outlines')->nullable()->after('benefits');
            $table->json('gallery_images')->nullable()->after('image_url');
            $table->string('cta_text')->nullable()->after('application_link');
            $table->string('stats_members')->nullable()->after('cta_text');
            $table->string('stats_investments')->nullable()->after('stats_members');
        });
    }

    public function down(): void
    {
        Schema::table('cooperative_settings', function (Blueprint $table) {
            $table->dropColumn(['heading', 'outlines', 'gallery_images', 'cta_text', 'stats_members', 'stats_investments']);
        });
    }
};
