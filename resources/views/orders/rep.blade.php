@php
  $menu_active = "orders";
  $prog_footer = env('prog_footer');
  @endphp
  @if (chk_para(session("user_info")["ui_para"], $menu_active."_add")=="no" and session("user_info")["ui_type"]!=="1")
       @php
       abort(403, "ليس لديك الصلاحية للوصول إلى هذه الصفحة.");
       @endphp
   @endif
   <head>
       <meta charset="utf-8">
   </head>
   <link rel="stylesheet" href="{{ asset('css/w3.css') }}" />
   <script type="text/javascript" src="{{ asset('js/hijri-date.js') }}"></script>
   <script type="text/javascript" src="{{ asset('js/calendar.js') }}"></script>
   <script type="text/javascript" src="{{ asset('js/datepicker.js') }}"></script>
   <script type="text/javascript" src="{{ asset('js/calendar_ini.js') }}"></script>
   <script type="text/javascript" src="{{ asset('js/axios.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('js/BsMultiSelect.min.js') }}"></script>
  
  
  <form class="row g-3 needs-validation" id="frm_rep" autocomplete="off" method="post">
    @csrf
  
  
      <div class="col">
        <div class="form-floating mb-1 float-end text-end max">
            <input class="form-control pull-right float-end text-end nowrite max"  onclick="xcalnder(event,'order_date_h_to','order_date_m_to')" name="order_date_to"   id="order_date_m_to" placeholder="تاريخ الاضافة" tabindex="1">
            <input class="hh" name="order_date_m" id="order_date_h_to">
            <label class="msg-right" for="message">تاريخ الاضافة إلى</label>
            <div class="invalid-feedback" id="order_date_error"></div>
        </div>
      </div>

      <div class="col">
          <div class="form-floating mb-1 float-end text-end max">
              <input class="form-control pull-right float-end text-end nowrite max"  onclick="xcalnder(event,'order_date_h','order_date_m')" name="order_date"   id="order_date_m" placeholder="تاريخ الاضافة" tabindex="1">
              <input class="hh" name="order_date_m" id="order_date_h">
              <label class="msg-right" for="message">تاريخ الاضافة من</label>
              <div class="invalid-feedback" id="order_date_error"></div>
          </div>
      </div>
              
      <div class="form-floating mb-1 float-end text-end">
                <select class="form-select float-end" name="pizza_name" id="pizza_name" tabindex="4">
                    <option value="">اختر من القائمة</option>
                    @php list_pizza(""); @endphp
                </select>
                <label class="msg-right" for="message">البيتزا</label>
                <div class="invalid-feedback" id="pizza_name_error"></div> 
            </div>

      <div class="form-floating mb-1 float-end text-end">
                  <select class="form-select float-end" name="pizza_size"   id="pizza_size" placeholder="الحجم" tabindex="6">
                    <option value="">الكل</option>
                    @php list_my_p_size(""); @endphp
                  </select>
                  <label class="msg-right" for="message">الحجم</label>
                  <div class="invalid-feedback" id="pizza_size_error"></div>
      </div>
            
      <div class="form-floating mb-1 float-end text-end">
          <select class="form-select float-end" name="pizza_type"   id="pizza_type" placeholder="النوع" tabindex="6">
                    <option value="">الكل</option>
                    @php list_my_p_type(""); @endphp
                  </select>
          <label class="msg-right" for="message">النوع</label>
          <div class="invalid-feedback" id="pizza_type_error"></div>
      </div>


      <div class="form-floating mb-1 float-end text-end"> 
          <input type="text" class="form-control pull-right float-end text-end only-numeric" name="price"   id="price" placeholder="السعر" tabindex="3">
          <label class="msg-right" for="message">السعر</label>
          <div class="invalid-feedback" id="price_error"></div>
      </div>
          
            
<div class="d-grid d-md-flex justify-content-md-end mx-auto">
 
  <button type="reset" class="btn btn-danger me-md-2 w-100">
    <i class="fas fa-eraser"></i>
    <b>تنظيف الحقول</b>
  </button>
  <button type="submit" formaction="{{ route('orders.rep_excel') }}" formtarget="_blank" class="btn btn-info me-md-2 w-100 rtl">
    <b>عرض التقرير Excel </b>
     <i class="far fa-file-excel"></i>
  </button>
  <button type="submit" formaction="{{ route('orders.rep_pdf') }}" formtarget="_blank" class="btn btn-primary me-md-2 w-100 rtl">
    <b>عرض التقرير PDF </b>
     <i class="far fa-file-pdf"></i>
  </button>
</div>
</form>
