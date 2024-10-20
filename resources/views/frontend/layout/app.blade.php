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
        
    <link rel="shortcut icon" href="{{asset('frontend/frontEnd/images/no_image.png')}}">
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

<!-- End Meta Pixel Code -->
</head>
<body>
<div class="main-wrapper">
@include('frontend.layout.header')

@section('main-content')
    
@show

@include('frontend.layout.footer')
    </div>
   
    </div>
    {{-- whatsapp connection  --}}
    <a href="https://wa.me/{{ preg_replace('/^0/', '+880', $user->company_phone) }}" class="" target="_blank" style="-webkit-appearance: none;" target="_blank" type="button" id="live_chat_btn">
       <img class="wapp_chat" src="https://amaarshop.com/frontend/frontEnd/images/wapp_logo.png" alt="Whats App Chat">
    </a>

		
	
<script src="{{asset('frontend/frontEnd/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('frontend/frontEnd/js/bootstrap.bundle.min.js')}}"></script>


<script src="{{asset('frontend/frontEnd/plugins/owl-carousel/owl.carousel.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{asset('frontend/backEnd/assets/vendor/toastr/toastr.min.js')}}"></script>
	<script>
  $(document).ready(function(){
    $('.header-right-m').click(function(){
      $('.cat_menu_m').hide();
    });
	
	 $('.main').click(function(){
      $('.cat_menu_m').hide();

    });
	
	
	
	
	 $('#cat_menu_mobile_btn').click(function(){
      $('.header-top-menu-m').hide();
	
	
  });
   
	
	
  });
</script>

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

@include('frontend.pages.main-js')

@yield('scripts')
	
</body>


</html>
