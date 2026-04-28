<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('sales', function (Blueprint $table) {
        $table->decimal('amount_received', 10, 2)->nullable();
        $table->decimal('change_amount', 10, 2)->nullable();
    });
}

public function down()
{
    Schema::table('sales', function (Blueprint $table) {
        $table->dropColumn(['amount_received', 'change_amount']);
    });
}
};
