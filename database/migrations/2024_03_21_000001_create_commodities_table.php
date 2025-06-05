<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commodities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('region');
            $table->decimal('price', 10, 2);
            $table->decimal('production', 10, 2);
            $table->decimal('area', 10, 2);
            $table->timestamp('last_updated');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commodities');
    }
}; 