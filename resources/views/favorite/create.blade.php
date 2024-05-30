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

  
<form class="row g-3 needs-validation" id="frm_add" autocomplete="off" method="post">
    @csrf

            <div class="form-floating mb-1 float-end text-end hh">
                    <input type="text" class="form-control pull-right float-end text-end nowrite"   onclick="xcalnder(event,'fav_add_date_m','fav_add_date')" name="fav_add_date" value="<?php echo set_stamp(); ?>"
                    id="fav_add_date" tabindex="1">
                    <input class="hh" name="fav_add_date_h" id="fav_add_date_m">
                <label class="msg-right " for="message">تاريخ الاضافة</label>
                <div class="invalid-feedback" id="fav_add_date_error"></div>        
            </div>
            
            <div class="form-floating mb-1 float-end text-end ">
                    <input type="text" class="form-control pull-right float-end text-end" name="name" value="{{$user->name}}"
                    id="name" tabindex="2">
                <label class="msg-right required" for="message">الاسم</label>
                <div class="invalid-feedback" id="name_error"></div>        
            </div>
            
        <div class="form-floating mb-1 float-end text-end"> 
                <input type="text" class="form-control pull-right float-end text-end only-numeric" name="age" value="{{old('age')}}"
                id="age"
                 tabindex="3">
            <label class="msg-right required" for="message">العمر</label>
            <div class="invalid-feedback" id="age_error"></div>        
        </div>
        
    <div class="form-floating mb-1 float-end text-end">
        <select class="form-select float-end" name="fav_pizza[]" id="fav_pizza" multiple="multiple" data-live-search="true">
                    <option value="">اختر من القائمة</option>
                    @php list_my_favorite(old('fav_pizza')); @endphp
                </select>
        <label class="msg-right required" for="message">تفضيلاتي</label>
        <div class="invalid-feedback" id="fav_pizza_error"></div>        
    </div>
  

    <div class="d-grid gap-2 col-6 mx-auto">
    <button class="btn btn-primary btn-block" type="submit">إضافة المعلومات</button>
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
    document.getElementById('frm_add').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        axios.post('/favorite.store', formData)
        .then(function (response) {
            //console.log("OK" + response);
            swal({text: "تمت الاضافة",icon: "success",timer: 1500,button: false,});
            $("#modal-add").modal("toggle");
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
                } else {
                    //console.log("Error", error.message);
                    swal({text: "خطأ في الأمر",icon: "error",timer: 2000,button: false,});
                    return false;
                }
                    //console.log(error.config);
        });
    });
</script>

<script>
$(function(){
     $(".only-numeric").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
             // Allow: Ctrl+A, Command+A, Ctrl+V 
            ((e.keyCode === 65 || e.keyCode === 86 ) && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
  
    
    $(".only-arabic-letters").keypress(function(event){
      // Arabic characters fall in the Unicode range 0600 - 06FF
          var arabicCharUnicodeRange = /[\u0600-\u06FF]/;
          var key = event.which;
            // 0 = numpad, 8 = backspace, 32 = space
            if (key==8 || key==0 || key === 32)
            {
              return true;
            }
            var str = String.fromCharCode(key);
            if ( arabicCharUnicodeRange.test(str) )
            {
              return true;
            }
            return false;			    	
    });
    
    $(".only-english-letters").keypress(function(event){
          var arabicCharUnicodeRange = /[a-zA-Z]/;
          var key = event.which;
           // 0 = numpad, 8 = backspace, 32 = space
            if (key==8 || key==0 || key === 32)
            {
              return true;
            }
            var str = String.fromCharCode(key);
            if ( arabicCharUnicodeRange.test(str) )
            {
              return true;
            }
            return false;			    	
    });		
    
    $(".only-english-alphanumeric").keypress(function(event){
          var arabicCharUnicodeRange = /[a-zA-Z0-9]/;
          var key = event.which;
           // 0 = numpad, 8 = backspace, 32 = space
            if (key==8 || key==0 || key === 32)
            {
              return true;
            }
            var str = String.fromCharCode(key);
            if ( arabicCharUnicodeRange.test(str) )
            {
              return true;
            }
            return false;			    	
    });

});
</script>
<script>
  $("#fav_pizza").bsMultiSelect();
  </script>

