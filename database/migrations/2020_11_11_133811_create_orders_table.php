<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //BUAT FILE orders
        Schema::create('orders', function (Blueprint $table) {
            //DAN FIELDNYA ADALAH DIBAWAH INI

            $table->bigIncrements('id');
            // $table->string('invoice')->unique();
            $table->string('customer_id');
            $table->date('tanggal');
            $table->string('status');
            // $table->unsignedBigInteger('district_id');
            $table->integer('jumlah_harga');
            $table->string('tujuan')->nullable();
            $table->timestamps();

           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
