<style>
  .menu-link {
    text-decoration: none !important;
  }

  .menu-link:hover {
    text-decoration: none;
  }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{route('admin.dashboard.index')}}" class="app-brand-link" style="">
      <img style="width: 200px" src="{{asset('green.png')}}" alt="">
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboards -->
    <li class="menu-item active open">
      <a href="{{route('admin.dashboard.index')}}" class="menu-link ">
        <i class="menu-icon fa-solid fa-gauge"></i>
        <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
        
      </a>
    </li>

    <!-- Slider -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon fa-solid fa-sliders"></i>
        <div class="text-truncate" data-i18n="Layouts">Slider</div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{route('admin.slider.page')}}" class="menu-link">
            <div class="text-truncate" data-i18n="Without menu">Add New</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{route('admin.slider.list')}}" class="menu-link">
            <div class="text-truncate" data-i18n="Without navbar">List</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Category -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon fa-solid fa-list"></i>
        <div class="text-truncate" data-i18n="Layouts">Category</div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{route('admin.category.page')}}" class="menu-link">
            <div class="text-truncate" data-i18n="Without menu">Add New</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{route('admin.category.list')}}" class="menu-link">
            <div class="text-truncate" data-i18n="Without navbar">List</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Product -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon fa-brands fa-product-hunt"></i>
        <div class="text-truncate" data-i18n="Layouts">Product</div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{route('admin.product.create')}}" class="menu-link">
            <div class="text-truncate" data-i18n="Without menu">Add New</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{route('admin.product.list')}}" class="menu-link">
            <div class="text-truncate" data-i18n="Without navbar">List</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Order -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon fa-brands fa-first-order"></i>
        <div class="text-truncate" data-i18n="Layouts">Order</div>
      </a>

      <ul class="menu-sub">
        {{-- <li class="menu-item">
          <a href="" class="menu-link">
            <div class="text-truncate" data-i18n="Without menu">Add New</div>
          </a>
        </li> --}}
        <li class="menu-item">
          <a href="{{route('admin.order.list')}}" class="menu-link">
            <div class="text-truncate" data-i18n="Without navbar">List</div>
          </a>
        </li>
      </ul>
    </li>

    {{-- Customize  --}}
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon fa-brands fa-intercom"></i>
        <div class="text-truncate" data-i18n="Layouts">Customize</div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{route('admin.top-header.list')}}" class="menu-link">
            <div class="text-truncate" data-i18n="Without menu">Meta Title</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{route('admin.logo.list')}}" class="menu-link">
            <div class="text-truncate" data-i18n="Without menu">Logo</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{route('admin.social_link.list')}}" class="menu-link">
            <div class="text-truncate" data-i18n="Without menu">Social Link</div>
          </a>
        </li>
       
      </ul>
    </li>

    <!-- Membership -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon fa-solid fa-users"></i>
        <div class="text-truncate" data-i18n="Layouts">Membership</div>
      </a>

      <ul class="menu-sub">
        {{-- <li class="menu-item">
          <a href="" class="menu-link">
            <div class="text-truncate" data-i18n="Without menu">Add New</div>
          </a>
        </li> --}}
        <li class="menu-item">
          <a href="{{route('admin.member.list')}}" class="menu-link">
            <div class="text-truncate" data-i18n="Without navbar">List</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- payment -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon fa-regular fa-credit-card"></i>
        <div class="text-truncate" data-i18n="Layouts">Payment</div>
      </a>

      <ul class="menu-sub">
       
        <li class="menu-item">
          <a href="" class="menu-link">
            <div class="text-truncate" data-i18n="Without navbar">List</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Settings -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon fa-solid fa-gear"></i>
        <div class="text-truncate" data-i18n="Layouts">Settings</div>
      </a>

      <ul class="menu-sub">
       
        <li class="menu-item">
          <a href="{{route('admin.profile.page')}}" class="menu-link">
            <div class="text-truncate" data-i18n="Without navbar">Profile</div>
          </a>
          <a href="{{route('admin.profile.update.page')}}" class="menu-link">
            <div class="text-truncate" data-i18n="Without navbar">Update Profile</div>
          </a>
          <a href="{{route('admin.profile.change.password.page')}}" class="menu-link">
            <div class="text-truncate" data-i18n="Without navbar">Change Password</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- Message -->
    {{-- <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link ">
        <i class="menu-icon fa-regular fa-envelope"></i>
        <div class="text-truncate" data-i18n="Layouts">Message</div>
      </a>

    </li> --}}

    
    
  </ul>
</aside>