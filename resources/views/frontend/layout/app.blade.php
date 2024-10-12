<?php 
    $meta=DB::table('meta')->where('status', 1)->first();
    $user=DB::table('users')->where('role_id', 1)->first();
?>
<style>
    .whatsapp-float {
        position: fixed;
        bottom: 20px;
        left: 20px;
        background-color: #25D366;
        color: white;
        border-radius: 50px;
        padding: 10px;
        font-size: 24px;
        box-shadow: 2px 2px 3px #999;
        z-index: 1000;
    }
    
    .whatsapp-float:hover {
        color: white;
        text-decoration: none;
    }
    
    .whatsapp-float i {
        display: block;
        margin: auto;
    }
</style>

<!doctype html>
<html lang="en">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta name="csrf-token" content="">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{$meta->title}} -     {{$sub_title}}</title>

    @if ($meta->fav_icon)
    <link rel="shortcut icon" href="{{asset('images/fav_icon/' . $meta->fav_icon)}}">
    @else
        
    <link rel="shortcut icon" href="frontend/frontEnd/images/no_image.png">
    @endif
    
    
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,300i,400,400i,600,600i,700,700i,800,800i&amp;display=swap" rel="stylesheet">
    
    <link href="{{asset('frontend/frontEnd/plugins/font-awesome/font-awesome.css')}}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5b135da28d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('frontend/frontEnd/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/frontEnd/css/style.css')}}">
    
    <link rel="stylesheet" href="{{asset('frontend/frontEnd/plugins/owl-carousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/frontEnd/plugins/owl-carousel/owl.theme.default.min.css')}}">
    
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/backEnd/assets/vendor/toastr/toastr.min.css')}}">
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
<!-- Meta Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '359203520520287');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=359203520520287&ev=PageView&noscript=1"
    /></noscript>
<!-- End Meta Pixel Code -->
</head>
<body>
<div class="main-wrapper">
@include('frontend.layout.header')

@section('main-content')
    
@show

@include('frontend.layout.footer')
    </div>
        <!-- Button to open the popup -->
        <div style="text-align: center; margin-top: 50px;">
    
        </div>

        <!-- Popup form -->
        <div class="popup" id="popupForm">
            <div class="popup-content">
                <button class="close-btn" id="closePopupBtn">&times;</button>

                <!-- Login Form -->
                <div id="loginForm" class="login_form">
                    <h2 style="">Login</h2>
                    <p>Don't have an account? <button class="toggle-btn" id="showRegisterForm">Register here</button></p>
                    <input type="text" 	style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc;  border-radius: 5px;  font-size: 16px; "placeholder="Username" id="loginUsername">
                    <input type="password" placeholder="Password" id="loginPassword" 	style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc;  border-radius: 5px;  font-size: 16px; ">
                    <button class="submit-btn">Login</button>
                    
                </div>

                <!-- Registration Form (Initially Hidden) -->
                <div id="registerForm" style="display: none;" class="login_form">
                    <h2>Register</h2>
                    <input type="text" placeholder="Username" id="registerUsername" 	style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc;  border-radius: 5px;  font-size: 16px; ">
                    <input type="email" placeholder="Email" id="registerEmail" 	style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc;  border-radius: 5px;  font-size: 16px; ">
                    <input type="password" placeholder="Password" id="registerPassword" 	style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc;  border-radius: 5px;  font-size: 16px; ">
                    <button class="submit-btn">Register</button>
                    <p>Already have an account? <button class="toggle-btn" id="showLoginForm">Login here</button></p>
                </div>
            </div>
        </div>
    </div>
    {{-- whatsapp connection  --}}
    <a href="https://wa.me/{{ preg_replace('/^0/', '+880', $user->company_phone) }}" class="whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
<script src="{{asset('frontend/frontEnd/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('frontend/frontEnd/js/bootstrap.bundle.min.js')}}"></script>


<script src="{{asset('frontend/frontEnd/plugins/owl-carousel/owl.carousel.min.js')}}"></script>


<script src="{{asset('frontend/backEnd/assets/vendor/toastr/toastr.min.js')}}"></script>

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

@include('frontend.pages.main-js')

@yield('scripts')
	
</body>


</html>
