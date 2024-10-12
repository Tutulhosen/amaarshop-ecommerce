@extends('backend.layout.app')


@section('main-content')
<a class="btn btn-success" href="{{route('admin.user.list')}}">User List</a>
   <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <h2 class="card-title" style="text-align:center">User Form</h2>
                
                <form class="forms-sample" id="myform">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" value="{{$user_info->name}}" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input type="email" class="form-control" id="email" value="{{$user_info->email}}" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="name">Phone</label>
                        <input type="text" class="form-control" id="phone" value="{{$user_info->phone}}" placeholder="Phone Number">
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select class="form-control" id="role_id" name="role_id">
                            <option value="">--Select--</option>
                            <option value="1" selected>Super Admin</option>
                        </select>
                    </div>
                    {{-- <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" value="{{$user_info->password}}" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" value="{{$user_info->password}}" placeholder="Confirm Password">
                    </div> --}}
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="img[]" id="category-image" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                        @if (!empty($user_info->image))
                            <div class="old_img" id="old_img" >
                                <img style="height: 100px; width:100px;object-fit:cover" src="{{asset('images/user/'.$user_info->image)}}" alt="">
                            </div>
                        @endif
                        
                        <div class="img_prev" id="img-preview" style="display: none">
                            <!-- Image preview will be shown here -->
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mr-2" id="user_update_btn" value="{{$user_info->id}}">Submit</button>
                    <button class="btn btn-dark">Cancel</button>
                </form>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
   </div>
@endsection
@section('scripts')
    

<script>
    

    $(document).ready(function(){
        
        $('#user_update_btn').on('click', function(){
       
            let id = $(this).val();
            var name = $('#name').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var role_id = $('#role_id').val();
            var password = $('#password').val();
            var confirm_password = $('#confirm_password').val();
            var image = $('#category-image')[0].files[0];

            if (name == '') {
                showToast('Enter A User Name', 'error');
                return; 
            }

            if (email == '') {
                showToast('Enter User Email', 'error');
                return; 
            }
            if (phone == '') {
                showToast('Enter User Phone number', 'error');
                return; 
            }

            if (role_id == '') {
                showToast('Select A Role For User', 'error');
                return; 
            }

            

            let formData = new FormData();
            formData.append('id', id);
            formData.append('name', name);
            formData.append('email', email);
            formData.append('phone', phone);
            formData.append('role_id', role_id);
            formData.append('password', password);
            formData.append('confirm_password', confirm_password);
            formData.append('image', image);
            formData.append('_token', '{{ csrf_token() }}'); 

            $.ajax({
                url: '{{ route('admin.user.update') }}', 
                method: 'POST',
                data: formData,
                contentType: false, 
                processData: false, 
                success: function(response) {
                    if (response.status==true) {
                        $('.img_prev').hide();
                        $('#old_img').load(location.href + ' #old_img');
                        $('#old_img').show();
                    
                        showToast(response.success, 'success');
                        
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



