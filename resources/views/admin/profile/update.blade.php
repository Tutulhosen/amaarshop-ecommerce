@extends('admin.layout.app')


@section('main-content')
    <div class="container pt-5">
        <form action="">
            <div class="row">
                <div class="col-4">
                    <div class="card-header" style="text-align: center">
                        <h3 style="color: green; font-weight:bold">Profile Image</h5><br>
                    </div>
                    <div class="mb-3" style="text-align: center">
                        @if (Auth::user()->image)
                        <img style="height: 200px; width:200px; border-radius:50%" id="imagePreview" class="image-preview"  src="{{asset('admin/assets/img/profile/' . Auth::user()->image)}}" alt="Image Preview">
                        @else
                        <img style="height: 200px; width:200px; border-radius:50%" id="imagePreview" class="image-preview"  src="{{asset('admin/assets/img/avatars/1.png')}}" alt="Image Preview">
                        @endif
                        
                    </div>
                    <div class="mb-3">
                        <label>Profile Image:</label>
                        <label for="imageUpload" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" name="img[]" id="imageUpload" accept="image/*">
                    </div>

                    
                    
                </div>
                <div class="col-4">
                    <div class="card-header" style="text-align: center">
                        <h3 style="color: green; font-weight:bold">Profile Information</h5><br>
                    </div>
                    

                    <div class="form-group">
                        <label for="">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ Auth::user()->name ? Auth::user()->name : '' }}">
                    </div><br>
                    <div class="form-group">
                        <label for="">Email:</label>
                        <input type="text" id="email" name="email" class="form-control" value="{{ Auth::user()->email ? Auth::user()->email : '' }}">
                    </div><br>
                    <div class="form-group">
                        <label for="">Phone:</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{Auth::user()->phone ? Auth::user()->phone : ''}}">
                    </div><br>

                    <div class="form-group">
                        <label for="">Address:</label>
                        <textarea name="address" id="address" cols="10" class="form-control">{{Auth::user()->address ? Auth::user()->address : ''}}</textarea>
                      
                    </div><br>
                    
                </div>
                <div class="col-4">
                    <div class="card-header" style="text-align: center">
                        <h3 style="color: green; font-weight:bold">Business Information</h5><br>
                    </div>
                    

                    <div class="form-group">
                        <label for="">Company Name:</label>
                        <input type="text"  name="company_name" id="company_name" class="form-control" value="{{Auth::user()->company_name ? Auth::user()->company_name : ''}}">
                    </div><br>
                    <div class="form-group">
                        <label for="">Company Email:</label>
                        <input type="text" name="company_email" id="company_email" class="form-control" value="{{Auth::user()->company_email ? Auth::user()->company_email : ''}}">
                    </div><br>
                    <div class="form-group">
                        <label for="">Company Phone:</label>
                        <input type="text"  name="company_phone" id="company_phone" class="form-control" value="{{Auth::user()->company_phone ? Auth::user()->company_phone : ''}}">
                    </div><br>
                    <div class="form-group">
                        <label for="">WhatsApp:</label>
                        <input type="text" id="whatsapp" name="whatsapp" id="whatsapp" class="form-control" value="{{Auth::user()->whatsapp ? Auth::user()->whatsapp : ''}}">
                    </div><br>

                    <div class="form-group">
                        <label for="">Address:</label>
                        <textarea name="company_address" id="company_address" cols="10" class="form-control">{{Auth::user()->company_address ? Auth::user()->company_address : ''}}</textarea>
                    </div><br>
                    
                    
                </div>
              
            </div>
            <div class="row">
                <div class="col-12" >
                    <button type="button" class="btn btn-success  w-100" id="update_btn">Update</button>
                </div>
            </div>
        </form>
        
    </div>
@endsection



@section('scripts')

<script>
    

    $(document).ready(function(){
        
        $('#update_btn').on('click', function(){
            
            var name = $('#name').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var address = $('#address').val();

            var company_name = $('#company_name').val();
            var company_email = $('#company_email').val();
            var company_phone = $('#company_phone').val();
            var whatsapp = $('#whatsapp').val();
            var company_address = $('#company_address').val();

            var profile_image = $('#imageUpload')[0].files[0]; 
            
          

            // Create a FormData object to send data with AJAX
            var formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('phone', phone);
            formData.append('address', address);
            formData.append('company_name', company_name);
            formData.append('company_email', company_email);
            formData.append('company_phone', company_phone);
            formData.append('whatsapp', whatsapp);
            formData.append('company_address', company_address);
            formData.append('profile_image', profile_image);
            
            formData.append('_token', '{{ csrf_token() }}');
           

            $.ajax({
                url: "{{route('admin.profile.update')}}", 
                method: 'POST',
                data: formData,
                contentType: false, 
                processData: false, 
                success: function(response) {
                    if (response.status==true) {
                    
                        showToast(response.success, 'success');
                        setTimeout(function() {
                            // Redirect to the list page
                            window.location.href = '/admin/profile/page';  
                        }, 1500);
                    }
                    if (response.status==false) {
                        
                        showToast(response.error, 'success');
                        
                    }
                    
                },
                
            });
        });





    });

</script>

@endsection
