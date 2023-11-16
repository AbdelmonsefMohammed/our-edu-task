<?php

declare(strict_types=1);

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
        Schema::create('transactions', static function (Blueprint $table) : void {
            $table->id();
            $table->foreignUuid('user_id')->index()->constrained()->cascadeOnDelete();
            $table->decimal('paidAmount', 8, 2);
            $table->string('currency');
            $table->string('statusCode');
            $table->date('paymentDate');
            $table->string('parentIdentification');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
