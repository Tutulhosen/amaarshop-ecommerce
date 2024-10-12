<?php
    $logo= DB::table('logo')->where('status', 1)->first();
    $admin= DB::table('users')->where('role_id', 1)->first();
?>
<header>
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-7">
                    <div class="header-left">
                        <p>Welcome to {{$admin->company_name}}</p>
                    </div>
                </div>

                <div class="col-md-8 col-5">
                    <div class="header-right">
                        <ul>
                            <li>
                                <i class="fa-solid fa-bag-shopping"></i>
                                <a href="{{route('shop.page')}}">
                                    <span>Shop</span>
                                </a>
                            </li>
                            @if (Auth::guard('customer')->check())
                                <li>
                                    <i class="fa fa-shopping-cart"></i>
                                    <a href="{{route('shopping.card')}}">
                                        <span>Checkout</span>
                                    </a>
                                </li>
                                <li>
                                    <span class="fa fa-user"></span>
                                    <a href="{{route('user.profile')}}">
                                        <span>Account</span>
                                    </a>
                                </li>
                                <li>
                                    <i class="fa fa-user" id="openPopupBtn"></i>
                                    <a href="{{route('frontend.customer.logout')}}" >
                                        Logout
                                        
                                    </a>
                                    
                                </li>
                            @else
                                <li>
                                    <i class="fa fa-shopping-cart"></i>
                                    <a href="{{route('shopping.card')}}">
                                        <span>Checkout</span>
                                    </a>
                                </li>
                                <li>
                                    <i class="fa fa-user" id="openPopupBtn"></i>
                                    <a href="{{route('frontend.login')}}" >
                                        Log In
                                        
                                    </a>
                                    
                                </li>
                            @endif
                            
                            
                            
                            
                            
                        </ul>
                    </div>

                    
                    <div class="header-right-m">
                        <ul>
                            <li class="position-relative">
                                {{-- <i class="fa fa-user" id="account-btn"></i> --}}
                                <div class="login-float">
                                    <div class="card">
                                        <div class="card-header">
                                            <p>Login</p>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{route('frontend.customer.login')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="_token" value="XXZrsl9wgpNRJBwrLcZyy76d5amKi0PaOHwQASGN">                                                    <div class="form-group mb-2">
                                                    <input type="text" class="form-control" placeholder="Mobile Number">
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control" placeholder="Password">
                                                </div>
                                                <button type="submit" class="btn btn-info w-100 mb-3">Login</button>
                                                <p>New Customer? <a href="{{route('frontend.register')}}">Signup</a></p>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </li>
                            <li class="position-relative">
                                <i class="fa fa-bars" id="header-top-menu-btn"></i>
                                <div class="header-top-menu-m">
                                    <ul>
                                        <li>
                                            <i class="fa-solid fa-bag-shopping"></i>
                                            <a href="{{route('shop.page')}}">
                                                <span>Shop</span>
                                            </a>
                                        </li>
                                        
                                        @if (Auth::guard('customer')->check())
                                            <li>
                                                <i class="fa fa-shopping-cart"></i>
                                                <a href="{{route('shopping.card')}}">
                                                    <span>Checkout</span>
                                                </a>
                                            </li>
                                            <li>
                                                <span class="fa fa-user"></span>
                                                <a href="{{route('user.profile')}}">
                                                    <span>Account</span>
                                                </a>
                                            </li>
                                            <li>
                                                <i class="fa fa-user" id="openPopupBtn"></i>
                                                <a href="{{route('frontend.customer.logout')}}" >
                                                    Logout
                                                    
                                                </a>
                                                
                                            </li>
                                        @else
                                            <li>
                                                <i class="fa fa-shopping-cart"></i>
                                                <a href="{{route('shopping.card')}}">
                                                    <span>Checkout</span>
                                                </a>
                                            </li>
                                            <li>
                                                <i class="fa fa-user" id="openPopupBtn"></i>
                                                <a href="{{route('frontend.login')}}" >
                                                    Log In
                                                    
                                                </a>
                                                
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-4 d-md-none cat_menu_btn_m">
                    <ul>
                        <li>
                            <i class="fa fa-bars" id="cat_menu_mobile_btn"></i>
                        </li>
                        <li>
                            <i class="fa fa-search" id="search_mobile_btn"></i>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 col-7 logo-m">
                    <div class="logo">
                        @if ($logo->image)
                        <a href="{{route('home')}}"><img src="{{asset('images/logo/' . $logo->image)}}" alt=""></a>
                        @else
                        <a href="{{route('home')}}"><img src="{{asset('frontend/uploads/6649146b6febe.png')}}" alt=""></a>
                        @endif
                       
                    </div>
                </div>

                <div class="col-md-6 py-md-3 d-none d-md-block">
                    <div class="search">
                        <form id="searchForm" method="get">
                            <select name="category" id="category" class="search-select">
                                <option value="">ক্যাটেগরীজ</option>
                                @foreach ($category as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            <input type="text" id="searchQuery" name="query" class="search-input" placeholder="সার্চ করুন">
                            <button type="submit" class="search-btn"><i class="fa fa-search" style="color: black;"></i></button>
                        </form>
                    </div>
                </div>
                
                

                <div class="col-md-3 text-md-right text-center py-3 cart-m">
                    <span class="cart-number d-none d-md-inline-block"><i class="fa fa-phone"></i> {{$admin->company_phone}}</span>
                    
                    <div class="cart d-inline-block position-relative">
                        <a href="{{ route('shopping.card') }}">
                            <i style="color: #fff" class="fa fa-2x fa-shopping-cart"></i>
                        </a>
                        <span id="cart-count" class="position-absolute badge rounded-pill bg-danger" style="display: {{ session('cart_count', 0) > 0 ? 'inline' : 'none' }}; color: white; font-size: 12px; padding: 5px 8px; top: 0; right: -22px;">
                            {{ session('cart_count', 0) }} <!-- Default to 0 if cart is empty -->
                        </span>
                    </div>
                    
                    
                </div>
            </div>
        </div>

        <div class="cat_menu_m">
            <ul>
                @foreach ($category as $item)
                    <li>
                        <a href="{{route('frontend.category.page', $item->id)}}">{{$item->name}}</a>
                    </li>
                @endforeach
                
               
            </ul>
        </div>

        <div class="search-form-m">
            <form id="searchForm" method="get">
                <select name="category" id="category" class="search-select">
                    <option value="">ক্যাটেগরীজ</option>
                    @foreach ($category as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                <input type="text" id="searchQuery" name="query" class="search-input" placeholder="সার্চ করুন">
                <button type="submit" class="search-btn"><i class="fa fa-search" style="color: black; padding-top:10px"></i></button>
            </form>
        </div>
        {{-- <div class="shop_btn">
            <a class="" href="{{route('shop.page')}}">Shop</a>
        </div> --}}
    </div>
<div class="header-bottom d-md-block d-none">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cat_menu">
                    <ul>
                        @foreach ($category as $item)
                            <li>
                                <a href="{{route('frontend.category.page', $item->id)}}">{{$item->name}}</a>
                            </li>
                        @endforeach
                        
                       
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


</header>

