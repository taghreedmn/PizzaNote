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
        Schema::create('pizzas', function (Blueprint $table) {
            $table->id();
            $table->date("my_p_add_date")->nullable()->comment("تاريخ الاضافة");
        
            $table->string("my_p_name")->comment("الاسم");
            
              $table->string("my_p_price")->comment("السعر");
          
            $table->text("my_p_type")->nullable()->comment("النوع");
          
            $table->text("my_p_toppings")->nullable()->comment("الإضافات");
            
            $table->string("my_p_size")->nullable()->comment("الحجم");
            
        $table->text("mypizza_log")->nullable()->comment("سجل العمليات");
      
        $table->string("mypizza_del")->nullable()->comment("هل محذوف");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pizzas');
    }
};
