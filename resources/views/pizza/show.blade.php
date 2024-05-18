@php
      $title = "بيتزا";
      $menu_active = "pizza";
      $prog_footer = env("prog_footer");
      $btn_title="إضافة بيتزا جديدة";
  @endphp
  
   @if (chk_para(session("user_info")["ui_para"], $menu_active."_show")=="no" and session("user_info")["ui_type"]!=="1")
       @php
       abort(403, "ليس لديك الصلاحية للوصول إلى هذه الصفحة.");
       @endphp
   @endif


	<div id="forprint">
    <div  class="">
      @include('layouts.hshow');
		  <hr class="hhp" />
	  <div>
		<table class="table table-bordered" style="direction:rtl">
      <tbody>
      <tr>
        <td class="text-center bg-infox" style="width: 35%;"><b>الرقم المميز</b></td>
        <td><b>{{$listings->id}}</b></td>
      </tr>

          <tr>
            <td class="text-center bg-infox" style="width: 35%;"><b>تاريخ الاضافة</b></td>
            <td><b>{{$listings->my_p_add_date}}</b></td>
          </tr>
          <tr>
            <td class="text-center bg-infox" style="width: 35%;"><b>الاسم</b></td>
            <td><b>{{$listings->my_p_name}}</b></td>
          </tr>
          <tr>
            <td class="text-center bg-infox" style="width: 35%;"><b>السعر</b></td>
            <td><b>{{$listings->my_p_price}}</b></td>
          </tr>
          <tr>
            <td class="text-center bg-infox" style="width: 35%;"><b>النوع</b></td>
            <td><b>{{get_my_p_type($listings->my_p_type)}}</b></td>
          </tr>
          <tr>
            <td class="text-center bg-infox" style="width: 35%;"><b>الإضافات</b></td>
            <td><b>{{show_my_p_toppings($listings->my_p_toppings)}}</b></td>
          </tr>
          <tr>
            <td class="text-center bg-infox" style="width: 35%;"><b>الحجم</b></td>
            <td><b>{{get_my_p_size($listings->my_p_size)}}</b></td>
          </tr>
        <tr>
        <td class="text-center bg-infox d-print-nonex" style="width: 35%;"><b>سجل العمليات</b></td>
        <td>
        <div class="accordion accordion-flush" id="div_acc_log">
          <div class="accordion-item">
            <p class="accordion-header" id="flush-headingOne">
              <button class="accordion-button collapsed p-1" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne"></button>
            </p>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#div_acc_log">
              <div class="accordion-body">
                @php echo nl2br_sp($listings->mypizza_log); @endphp
              </div>
            </div>
          </div>
        </div>
        </td>
        </tr>
</tbody>
      </table>
       </div>    
	    <div class="mx-auto d-print-none">
      @if (chk_para(session("user_info")["ui_para"], $menu_active."_del")=="ok" or session("user_info")["ui_type"]=="1")
            <a class="btn btn-danger del" onclick="del('<?php echo enc($listings->id); ?>');" href="#modal-del" data-bs-target="#modal-del"><i class="fas fa-trash"></i> حذف</a>
      @endif
      
      @if (chk_para(session("user_info")["ui_para"], $menu_active."_edit")=="ok" or session("user_info")["ui_type"]=="1")
            <a class="btn btn-info" data-bs-toggle="modal" data-remote="{{ route('pizza.edit', enc($listings->id) ) }}"  data-bs-target="#modal-edit"><i class="fas fa-edit"></i> تعديل</a>
      @endif

            <a href="javascript:void(0);" class="btn btn-success" id="print"><i class="fas fa-print"></i> طباعة</a>
		  </div>
	</div>
</div>
  <script>
    $(document).ready(function(){
        $("#print").click(function(){
            var mode = "iframe"; // popup
            var close = mode == "popup";
            var options = { mode : mode, popClose : close};
            $("#forprint").printArea( options );
        });
    });

  </script>
