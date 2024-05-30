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
<script type="text/javascript" src="{{ asset('js/BsMultiSelect.min.js') }}"></script>


  <div class="alert alert-warning rtl hh" id="upload_pic" role="alert">
  <p><b>تعليمات رفع الصور</b></p>
    <li>الحجم الأقصى المسموح به هو : 3 ميغا</li>
    <li>صيغ الصور المدعومة هي : PNG,JPG,JPEG,HEIC</li>
</div>

<div class="alert alert-warning rtl hh" id="upload_doc" role="alert">
<p><b>تعليمات رفع الملفات</b></p>
  <li>الحجم الأقصى المسموح به هو : 3 ميغا</li>
  <li>صيغ الملفات المدعومة هي : DOC,DOCX,PDF,XCLX</li>
</div>

  <form class="row g-3 needs-validation" id="frm_edit" autocomplete="off" novalidate method="post">
    @csrf
 
                    <div class="form-floating mb-1 float-end text-end">
                      <input class="form-control pull-right float-end text-end nowrite"  onclick="xcalnder(event,'order_date_h','order_date_m')" name="order_date"   required " data-error-msg="يجب تعبئة تاريخ الاضافة" id="order_date_h" placeholder="تاريخ الاضافة" tabindex="1" value="{{ $listings->order_date }}">
                      
                      <input class="hh" name="order_date_h" id="order_date_h">
                      
                      <label class="msg-right required " data-error-msg="يجب تعبئة تاريخ الاضافة" for="message">تاريخ الاضافة</label>
                       <div class="invalid-feedback" id="order_date_error"></div>        
                    </div>

            <div class="form-floating mb-1 float-end text-end">
                <select class="form-select float-end" name="pizza_name" id="pizza_name" tabindex="4">
                    <option value="">اختر من القائمة</option>
                    @php list_pizza($listings-> pizza_name); @endphp
                </select>
                <label class="msg-right required" for="message">البيتزا</label>
                <div class="invalid-feedback" id="pizza_name_error"></div> 
            </div>

         
          <div class="form-floating mb-1 float-end text-end">
           <select class="form-select pull-right float-end " name="pizza_type"   required id="pizza_type_edit" placeholder="النوع" tabindex="6">
              <option value="">اختر من القائمة</option>
              <?php echo list_my_p_type($listings->pizza_type); ?>
            </select>
           <label class="msg-right required" for="message">النوع</label>
           <div class="invalid-feedback">مطلوب النوع</div>
        </div>
          
                
        <div class="form-floating mb-1 float-end text-end">
           <select class="form-select pull-right float-end " name="pizza_size"   required id="pizza_size_edit" placeholder="الحجم" tabindex="6">
              <option value="">اختر من القائمة</option>
              <?php echo list_my_p_size($listings->pizza_size); ?>
            </select>
           <label class="msg-right required" for="message">الحجم</label>
           <div class="invalid-feedback">مطلوب الحجم</div>
        </div>
        
        <div class="form-floating mb-1 float-end text-end" id="div_toppings" dir="rtl">
    <label class="col-form-label float-end " for="toppings">الإضافات</label>
    <select name="toppings[]" id="toppings" class="form-select toppings"  multiple="multiple" data-live-search="true">
                    @php list_my_p_toppings_edit($listings->toppings);@endphp
                </select>
        <div class="invalid-feedback" id="toppings_error"></div>        
    </div>
    <div class="form-floating mb-1 float-end text-end ">
        <input type="text" class="form-control pull-right float-end text-end" name="notes" id="notes" tabindex="2" value = "{{$listings->notes}}">
        <label class="msg-right " for="message">ملاحظات</label>
        <div class="invalid-feedback" id="name_error"></div>        
    </div>
        
<div class="d-grid gap-2 col-6 mx-auto">
<button class="btn btn-info btn-block" type="submit">تحديث المعلومات</button>
</div>
</form>

<script>
    $(function(){
        $(":input[data-inputmask-mask]").inputmask();
        $(":input[data-inputmask-alias]").inputmask();
        $(":input[data-inputmask-regex]").inputmask("Regex");
    });
</script>

<script>
    document.getElementById('frm_edit').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('id','{{ enc($listings->id) }}');
        axios.post('/orders.update', formData)
        .then(function (response) {
            //console.log("OK" + response);
            swal({text: "تم التحديث",icon: "success",timer: 1500,button: false,});
            $("#modal-edit").modal("toggle");
            setTimeout(function(){location.reload();}, 1500);
        })
        .catch(function (error) {
            if (error.response) {
                    console.log("Errxxx = ",error.response.data);
                    swal({text: "خطأ في الاستجابة",icon: "error",timer: 2000,button: false,});
                    //return false;
                if (error.response.data.errors) {
                        var errors = error.response.data.errors;

                    for (var fieldName in errors) {
                        var errorMessage = errors[fieldName][0];
                        var errorElement = document.getElementById(fieldName + '_error');
                        var mainElement = document.getElementById(fieldName);

                        if (errorElement) {
                            errorElement.innerText = errorMessage;
                            errorElement.style.display = 'block';
                            mainElement.style.border = '1px solid red';
                        }
                    }
                }
            } else if (error.request) {
                //console.log(error.request);
                    swal({text: "خطأ في الطلب",icon: "error",timer: 2000,button: false,});
                    return false;
                }
        });
    });
</script>
<script>
  $("#toppings").bsMultiSelect();
</script>
