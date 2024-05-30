<nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
<ul class="app-menu list-unstyled accordion" id="menu-accordion">
  
    <li class="nav-item">
  <!--//Bootstrap Icons: https://icons.getbootstrap.com/ or https://fontawesome.com/v6/search?o=r&m=free -->
  <a class="nav-link @php if($menu_active=="home"){echo "active";}else{echo "";} @endphp" href="{{ route('dashboard') }}">
    <span class="nav-icon @php if($menu_active=="home"){echo "activex";}else{echo "";} @endphp">
      <i class="fas fa-home fa-lg"></i>
    </span>
    <span class="nav-link-text @php if($menu_active=="home"){echo "activex";}else{echo "";} @endphp">الرئيسية</span>
  </a>
</li>

@if (chk_para(session('user_info')['ui_para'], $menu_active."_show")=="ok" or session('user_info')['ui_type']=="1")
    <li class="nav-item">
      <a class="nav-link @php if($menu_active=="users"){echo "active";}else{echo "";} @endphp" href="{{ route('users_info.list') }}">
        <span class="nav-icon @php if($menu_active=="users"){echo "activex";}else{echo "";} @endphp">
          <i class="fas fa-users fa-lg"></i>
        </span>
        <span class="nav-link-text @php if($menu_active=="users"){echo "activex";}else{echo "";} @endphp">المستخدمون</span>
      </a>
    </li>
@endif 

@if (chk_para(session('user_info')['myfrind'], $menu_active."_show")=="ok" or session('user_info')['ui_type']=="1")
    <li class="nav-item">
      <a class="nav-link @php if($menu_active=="myfrind"){echo "active";}else{echo "";} @endphp" href="{{ route('myfrind.list') }}">
        <span class="nav-icon @php if($menu_active=="myfrind"){echo "activex";}else{echo "";} @endphp">
          <i class="far fa-calendar-alt fa-lg"></i>
        </span>
        <span class="nav-link-text @php if($menu_active=="myfrind"){echo "activex";}else{echo "";} @endphp">الأصدقاء</span>
      </a>
    </li>
@endif 

@if (chk_para(session('user_info')['pizza'], $menu_active."_show")=="ok" or session('user_info')['ui_type']=="1")
    <li class="nav-item">
      <a class="nav-link @php if($menu_active=="pizza"){echo "active";}else{echo "";} @endphp" href="{{ route('pizza.list') }}">
        <span class="nav-icon @php if($menu_active=="pizza"){echo "activex";}else{echo "";} @endphp">
          <i class="far fa-calendar-alt fa-lg"></i>
        </span>
        <span class="nav-link-text @php if($menu_active=="pizza"){echo "activex";}else{echo "";} @endphp">بيتزا</span>
      </a>
    </li>
@endif 
@if (chk_para(session('user_info')['favorite'], $menu_active."_show")=="ok" or session('user_info')['ui_type']=="1")
    <li class="nav-item">
      <a class="nav-link @php if($menu_active=="favorite"){echo "active";}else{echo "";} @endphp" href="{{ route('favorite.list') }}">
        <span class="nav-icon @php if($menu_active=="favorite"){echo "activex";}else{echo "";} @endphp">
          <i class="far fa-calendar-alt fa-lg"></i>
        </span>
        <span class="nav-link-text @php if($menu_active=="favorite"){echo "activex";}else{echo "";} @endphp">تفضيلاتي</span>
      </a>
    </li>
@endif 
@if (chk_para(session('user_info')['orders'], $menu_active."_show")=="ok" or session('user_info')['ui_type']=="1")
    <li class="nav-item">
      <a class="nav-link @php if($menu_active=="orders"){echo "active";}else{echo "";} @endphp" href="{{ route('orders.list') }}">
        <span class="nav-icon @php if($menu_active=="orders"){echo "activex";}else{echo "";} @endphp">
          <i class="far fa-calendar-alt fa-lg"></i>
        </span>
        <span class="nav-link-text @php if($menu_active=="orders"){echo "activex";}else{echo "";} @endphp">طلباتي</span>
      </a>
    </li>
@endif



</ul><!--//app-menu-->
</nav>

</div>
</div>
<script src="{{ asset('js/menu.js') }}"></script>
</header>
