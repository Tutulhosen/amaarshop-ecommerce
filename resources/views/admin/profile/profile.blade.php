@extends('admin.layout.app')


@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-6">
                
                <div class="profile_div" style="padding: 20px; text-align:center; color:green">
                    <div class="card-header">
                        <h3 style="color: green; font-weight:bold">Profile Information</h5><br>
                    </div>
                    @if (Auth::user()->image)
                    <img src="{{asset('admin/assets/img/profile/' . Auth::user()->image)}}" alt="" style="height: 200px; width:200px; border-radius:50%"><br><br>
                    @else
                    <img src="{{asset('admin/assets/img/avatars/1.png')}}" alt="" style="height: 200px; width:200px; border-radius:50%"><br><br>
                    @endif
                    
                    <h5><strong>Name:</strong> {{Auth::user()->name}}</h5><br>
                    <h5><strong>Email:</strong> {{Auth::user()->email}}</h5><br>
                    <h5><strong>Phone:</strong> {{Auth::user()->phone}}</h5>
            
                </div>
            </div>
            <div class="col-6">
                <div class="profile_div" style="padding: 20px;  color:green">
                    <div class="card-header">
                        <h3 style="color: green; font-weight:bold">Business Information</h5><br>
                    </div>
                    
                    <h5 style="color: rgb(20, 33, 82)"><strong style="color: rgb(114, 127, 83)">Company Name:</strong> {{Auth::user()->company_name}}</h5><br>
                    <h5 style="color: rgb(20, 33, 82)"><strong style="color: rgb(114, 127, 83)">Company Email:</strong> {{Auth::user()->company_email}}</h5><br>
                    <h5 style="color: rgb(20, 33, 82)"><strong style="color: rgb(114, 127, 83)">Company Phone:</strong> {{Auth::user()->company_phone}}</h5><br>
                    <h5 style="color: rgb(20, 33, 82)"><strong style="color: rgb(114, 127, 83)">WhatsApp:</strong> {{Auth::user()->whatsapp}}</h5><br>
                    <h5 style="color: rgb(20, 33, 82)"><strong style="color: rgb(114, 127, 83)">Address:</strong> {{Auth::user()->company_address}}</h5>
            
                </div>
            </div>
          
        </div>
    </div>
@endsection




