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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_method')->default('gateway');
            $table->string('proof_of_payment')->nullable();
        });

        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->text('instructions')->nullable();
            $table->timestamps();
        });

        // Seed default payment details
        \DB::table('payment_settings')->insert([
            'bank_name' => 'Access Bank',
            'account_number' => '0123456789',
            'account_name' => 'UNIBEN Alumni Association Lagos Branch',
            'instructions' => 'Please make payment to the account above and upload the receipt/proof of payment here for confirmation.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'proof_of_payment']);
        });

        Schema::dropIfExists('payment_settings');
    }
};
