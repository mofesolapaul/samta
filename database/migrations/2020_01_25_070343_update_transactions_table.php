<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('amount', 'sent_amount');
            $table->decimal('received_amount');
            $table->decimal('sender_balance')->nullable()->change();
            $table->decimal('receiver_balance')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('receiver_balance')->nullable()->change();
            $table->decimal('sender_balance')->nullable()->change();
            $table->dropColumn('received_amount');
            $table->renameColumn('sent_amount', 'amount');
        });
    }
}
