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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('الاسم');
            $table->text('age')->comment('العمر');
            $table->text('fav_pizza')->nullable()->comment('البيتزا المفضلة');
            $table->date("fav_add_date")->nullable()->comment("تاريخ الاضافة");
            $table->text("fav_log")->nullable()->comment("سجل العمليات");
            $table->string("fav_del")->nullable()->comment("هل محذوف");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
