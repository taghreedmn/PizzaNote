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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment('رقم_العميل');
            $table->integer('pizza_id')->nullable()->comment('رقم_البيتزا');
            $table->string('user_name')->nullable()->comment('اسم_العميل ');
            $table->string('pizza_name')->nullable()->comment('اسم_البيتزا ');
            $table->string('pizza_size')->nullable()->comment('الحجم');
            $table->string('pizza_type')->nullable()->comment('نوع_البيتزا');
            $table-> integer('price')->nullable()->comment('السعر');
            $table->date("order_date")->nullable()->comment("تاريخ الاضافة");
            $table->text("toppings")->nullable()->comment("الإضافات");
            $table -> integer('order_status')->nullable()->comment('حالة_الطلب');
            $table->text("notes")->nullable()->comment("ملاحظات");
            $table->text("order_log")->nullable()->comment("سجل العمليات");
            $table->string("order_del")->nullable()->comment("هل محذوف");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
