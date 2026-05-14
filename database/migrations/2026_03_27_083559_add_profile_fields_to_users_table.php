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
        Schema::table('users', function (Blueprint $table) {
            $table->string('degree')->nullable();
            $table->string('graduation_year')->nullable();
            $table->string('job_title')->nullable();
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('alumni_id')->nullable();
            $table->string('membership_type')->default('Non-Member');
            $table->integer('connections_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'degree', 'graduation_year', 'job_title', 'company', 
                'phone', 'location', 'linkedin_url', 'alumni_id', 
                'membership_type', 'connections_count'
            ]);
        });
    }
};
