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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accommodation_id');
            $table->timestamp('date');
            $table->decimal('base_price',11);
            $table->decimal('adult_price',11);
            $table->decimal('child_price',11);
            $table->decimal('infant_price',11);
            $table->boolean('is_reserved')->default(false);
            $table->timestamps();

            $table->index(['accommodation_id', 'is_reserved', 'date'], 'calendars_acc_rsv_dte_idx');
            $table->index(
                ['accommodation_id', 'is_reserved', 'date', 'base_price', 'adult_price', 'child_price', 'infant_price'],
                'calendars_acc_rsv_dte_bse_adt_cld_inf_idx'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};
