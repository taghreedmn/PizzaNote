@php
    $menu_active = "favorite";
    $prog_footer = env('prog_footer');
    @endphp
    @if (chk_para(session("user_info")["ui_para"], $menu_active."_add")=="no" and session("user_info")["ui_type"]!=="1")
         @php
         abort(403, "ليس لديك الصلاحية للوصول إلى هذه الصفحة.");
         @endphp
     @endif
     @php
  
  $user = Auth::user();
  //dd(session('user_info')['id']);
  //dd($user->name);
  @endphp
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

  
<form class="row g-3 needs-validation" id="frm_edit" autocomplete="off" method="post">
    @csrf

            <div class="form-floating mb-1 float-end text-end hh">
                    <input type="text" class="form-control pull-right float-end text-end nowrite"   onclick="xcalnder(event,'fav_add_date_m','fav_add_date')" name="fav_add_date" value="{{$listings-> fav_add_date}}"
                    id="fav_add_date" tabindex="1">
                    <input class="hh" name="fav_add_date_h" id="fav_add_date_m">
                <label class="msg-right " for="message">تاريخ الاضافة</label>
                <div class="invalid-feedback" id="fav_add_date_error"></div>        
            </div>
            
            <div class="form-floating mb-1 float-end text-end hh">
                    <input type="text" class="form-control pull-right float-end text-end" name="name" value="{{$listings->name}}"
                    id="name" tabindex="2">
                <label class="msg-right required" for="message">الاسم</label>
                <div class="invalid-feedback" id="name_error"></div>        
            </div>
            
        <div class="form-floating mb-1 float-end text-end"> 
                <input type="text" class="form-control pull-right float-end text-end only-numeric" name="age" value="{{$listings -> age}}"
                id="age"
                 tabindex="3">
            <label class="msg-right required" for="message">العمر</label>
            <div class="invalid-feedback" id="age_error"></div>        
        </div>
        
    <div class="form-floating mb-1 float-end text-end" id="div_fav_pizza" dir="rtl">
    <label class="col-form-label float-end required" for="fav_pizza">تفضيلاتي</label>
        <select class="form-select fav_pizza" name="fav_pizza[]" id="fav_pizza" multiple="multiple" data-live-search="true">
                @php list_my_favorite($listings->fav_pizza); @endphp
                </select>
        <div class="invalid-feedback" id="fav_pizza_error"></div>   
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
        axios.post('/favorite.update', formData)
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
     function set_txt_para(){
      
        if($("#fav_pizza :selected")){
        $("#fav_pizza").attr("required",false);
      }
      
    }
</script>
<script>
  $("#fav_pizza").bsMultiSelect();
  set_txt_para();
  </script>
