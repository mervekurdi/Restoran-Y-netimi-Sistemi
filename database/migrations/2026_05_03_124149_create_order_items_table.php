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
         Schema::create('order_items', function (Blueprint $table) {

        $table->id(); //  ürün numarası 

        $table->foreignId('order_id')->constrained()->onDelete('cascade'); // istekle bağlantı kurma

        $table->string('name'); // yemeğin adı

        $table->integer('price'); // fiyat

        $table->integer('quantity'); // miktar

        $table->timestamps(); // tarih
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
