<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('payment_request', function (Blueprint $table) {
            $table->id();
            $table->string('order_id',30)->unique();
            $table->string('mode',4)->nullable();            
            $table->decimal('amount', 12,2);
            $table->string('currency',3);
            $table->string('description',255);
            $table->string('name',255);
            $table->string('email',255);
            $table->string('phone',30);
            $table->string('address_line_1',255)->nullable();
            $table->string('address_line_2',255)->nullable();
            $table->string('city',255);
            $table->string('state',255)->nullable();
            $table->string('country',100);
            $table->string('zip_code',20);
            $table->string('payment_status',100)->default('PROGRESS');
            $table->string('response_code',10)->nullable();
            $table->string('transaction_id',255)->nullable();
            $table->string('payment_channel',255)->nullable();
            $table->string('payment_mode',100)->nullable();
            $table->string('response_datetime',10)->nullable();
            $table->string('response_message',255)->nullable();
            $table->string('refund_id',10)->nullable();
            $table->string('refund_referance_no',10)->nullable();
            $table->timestamp('updated_at')->nullable(); 
            $table->timestamp('creation_datetime');                      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
