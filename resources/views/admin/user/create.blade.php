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
                        <input type="text" class="form-control" id="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="name">Phone</label>
                        <input type="text" class="form-control" id="phone" placeholder="Phone Number">
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select class="form-control" id="role_id" name="role_id">
                            <option value="">--Select--</option>
                            <option value="1">Super Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password">
                    </div>
                    <div class="form-group">
                        <label> Image</label>
                        <input type="file" name="img[]" id="category-image" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                        <div class="img_prev" id="img-preview" style="display: none">
                            <!-- Image preview will be shown here -->
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mr-2" id="user_subnit_btn">Submit</button>
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
        
        $('#user_subnit_btn').on('click', function(){
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

            if (password == '') {
                showToast('Enter A Password', 'error');
                return; 
            }
            if (confirm_password == '') {
                showToast('Enter Confirm Password', 'error');
                return; 
            }
            if (confirm_password !== password) {
                showToast('Password Not Match', 'error');
                return; 
            }

            

            let formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('phone', phone);
            formData.append('role_id', role_id);
            formData.append('password', password);
            formData.append('confirm_password', confirm_password);
            formData.append('image', image);
            formData.append('_token', '{{ csrf_token() }}'); 

            $.ajax({
                url: '{{ route('admin.user.store') }}', 
                method: 'POST',
                data: formData,
                contentType: false, 
                processData: false,
                success: function(response) {
                    if (response.status==true) {
                        $('.img_prev').hide();
                        $("#myform")[0].reset();
                        showToast(response.success, 'success');
                        
                    }
                    
                },
                
            });
        });





    });

</script>

@endsection



