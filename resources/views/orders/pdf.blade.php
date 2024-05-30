@php
  $page_title = "طلباتي";
  $menu_active = "orders";
  @endphp
  
  @if (chk_para(session('user_info')['ui_para'], $menu_active."_rep")=="no" and session('user_info')['ui_type']!=="1")
      @php
      abort(403, "ليس لديك الصلاحية للوصول إلى هذه الصفحة");
      @endphp
  @endif
  <style>
      .text-center{
        align-items: center;
        text-align: center;
      }
      .tbg{
        background-color :#bcbcbc ;
        padding: 5px;
    }
  </style>
<table class="text-center" cellspacing="0" cellpadding="5" border="1">
  <thead>
      <tr>
        <th class="tbg text-center" width="13.7%"><b>الرقم</b></th>
        <th class="tbg text-center" width="13.7%"><b>تاريخ الاضافة</b></th>
        <th class="tbg text-center" width="13.7%"><b>اسم البيتزا</b></th>
        <th class="tbg text-center" width="13.7%"><b>الحجم</b></th>
        <th class="tbg text-center" width="13.7%"><b>النوع</b></th>
        <th class="tbg text-center" width="13.7%"><b>الإضافات</b></th>
        <th class="tbg text-center" width="13.7%"><b>السعر</b></th>

      </tr>
    </thead>
  <tbody>
                @unless ($listings->isEmpty())
                @foreach ($listings as $key => $list)
  <tr>
  <td class="text-center" width="13.7%"><?php echo $list->id; ?></td>
      <td class="text-center" width="13.7%"><?php echo $list->order_date; ?></td>
          <td class="text-center" width="13.7%"><?php echo $list->pizza_name; ?></td>
          <td class="text-center" width="13.7%"><?php echo get_my_p_size($list->pizza_size); ?></td>
          <td class="text-center" width="13.7%"><?php echo get_my_p_type($list->pizza_type); ?></td>
          <td class="text-center" width="13.7%"><?php echo show_my_p_toppings($list->toppings);?></td>
          <td class="text-center" width="13.7%"><?php echo $list->price; ?></td>
          
        </tr>
                    @endforeach
                    @endunless
      </tbody>
    </table>
  