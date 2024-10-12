@extends('admin.layout.app')


@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="card mt-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="headline">
                                <h3 class="text-center">Change Password </h3>
                            </div>
                            <br>
                            <form class="forms-sample" id="myform">
                                <div class="form-group">
                                    <label for="name">Current Password </label>
                                    <input type="password" class="form-control" id="c_password" >
                                </div>
                                <br>

                                <div class="form-group">
                                    <label for="name">New Password </label>
                                    <input type="password" class="form-control" id="new_password">
                                </div>
                                <br>

                                <div class="form-group">
                                    <label for="name">Confirm Password </label>
                                    <input type="password" class="form-control" id="confirm_password">
                                </div>
                                <br>
                                
                                <button type="button" class="btn btn-success mr-2" id="subnit_btn">Submit</button>
                                <button class="btn btn-dark">Cancel</button>
                            </form>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
@endsection
@section('scripts')
    

<script>
    

    $(document).ready(function(){
        
        $('#subnit_btn').on('click', function(){
            let c_password = $('#c_password').val();
            let new_password = $('#new_password').val();
            let confirm_password = $('#confirm_password').val();
         
            if (c_password == '' || new_password == '' || confirm_password == '') {
                showToast('Fill up all input field', 'error');
                return; 
            }


            let formData = new FormData();
            formData.append('c_password', c_password);
            formData.append('new_password', new_password);
            formData.append('confirm_password', confirm_password);
            formData.append('_token', '{{ csrf_token() }}'); 

            $.ajax({
                url: '{{ route('admin.profile.change.password') }}', 
                method: 'POST',
                data: formData,
                contentType: false, 
                processData: false,
                success: function(response) {
                    if (response.status==true) {
                        
                        showToast(response.success, 'success');
                        // setTimeout(function() {
                            
                        //     window.location.href = '/admin/top-header/list';  
                        // }, 1500);
                        
                    }

                    if (response.status==false) {
                        
                        showToast(response.error, 'error');
                        
                        
                    }
                    
                },
                
            });
        });


    });

</script>

@endsection



