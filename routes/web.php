<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users_info\Users_info_cnt;
use App\Http\Controllers\PDFController;
//---> any new below

use App\Http\Controllers\myfrind\Myfrind_cnt;
use App\Http\Controllers\Pizza\Pizza_cnt;

Route::get("/", function () {
  if (Auth::check()) {
      return view("dashboard");
  } else {
      return redirect()->route("login");
  }
});
Route::middleware("auth")->group(function () {

    Route::get("/dashboard",function(){return view("dashboard");})->name("dashboard");
    Route::get("users_info/list", [Users_info_cnt::class, "list"])->name("users_info.list");
    Route::get("users_info/{{users_info}}/show", [Users_info_cnt::class, "show"])->name("users_info.show");
    Route::get("users_info/pass", [Users_info_cnt::class, "pass"])->name("users_info.pass");
    Route::get("users_info/rep", [Users_info_cnt::class, "rep"])->name("users_info.rep");
    Route::post("users_info.rep_excel", [Users_info_cnt::class, "rep_excel"])->name("users_info.rep_excel");
    Route::post("users_info.rep_pdf", [Users_info_cnt::class, "rep_pdf"])->name("users_info.rep_pdf");
    Route::post("users_info.store", [Users_info_cnt::class, "store"]);
    Route::post("users_info.update", [Users_info_cnt::class, "update"]);
    Route::post("users_info.upass", [Users_info_cnt::class, "upass"]);
    Route::resource("users_info", Users_info_cnt::class);

    Route::get("myfrind/list", [Myfrind_cnt::class, "list"])->name("myfrind.list");
    Route::get("myfrind/{{myfrind}}/show", [Myfrind_cnt::class, "show"])->name("myfrind.show");
    Route::get("myfrind/rep", [Myfrind_cnt::class, "rep"])->name("myfrind.rep");
    Route::post("myfrind.rep_excel", [Myfrind_cnt::class, "rep_excel"])->name("myfrind.rep_excel");
    Route::post("myfrind.rep_pdf", [Myfrind_cnt::class, "rep_pdf"])->name("myfrind.rep_pdf");
    Route::post("myfrind.store", [Myfrind_cnt::class, "store"]);
    Route::post("myfrind.update", [Myfrind_cnt::class, "update"]);
    Route::resource("myfrind", Myfrind_cnt::class);

    Route::get("pizza/list", [Pizza_cnt::class, "list"])->name("pizza.list");
    Route::get("pizza/{{pizza}}/show", [Pizza_cnt::class, "show"])->name("pizza.show");
    Route::get("pizza/rep", [Pizza_cnt::class, "rep"])->name("pizza.rep");
    Route::post("pizza.rep_excel", [Pizza_cnt::class, "rep_excel"])->name("pizza.rep_excel");
    Route::post("pizza.rep_pdf", [Pizza_cnt::class, "rep_pdf"])->name("pizza.rep_pdf");
    Route::post("pizza.store", [Pizza_cnt::class, "store"]);
    Route::post("pizza.update", [Pizza_cnt::class, "update"]);
    Route::resource("pizza", Pizza_cnt::class);
   
   //---- Any New Line Add Below

});

require __DIR__."/auth.php";

