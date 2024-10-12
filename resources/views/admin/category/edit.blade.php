@extends('admin.layout.app')


@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <div class="card mt-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="headline">
                                <h3 class="text-center">Update Category</h3>
                            </div>
                            <br>
                            <form class="forms-sample" id="myform">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Category Name</label>
                                    <input type="text" class="form-control" id="name" value="{{$category_info->name}}" placeholder="Username">
                                </div>
                                <br>
                                <button type="button" class="btn btn-success mr-2" id="cat_update_btn" value="{{$category_info->id}}">Submit</button>
                                <button class="btn btn-dark">Cancel</button>
                            </form>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
@endsection
@section('scripts')
    

<script>
    

    $(document).ready(function(){
        
        $('#cat_update_btn').on('click', function(){
        let name = $('#name').val();
        let id = $(this).val();
       
        

        if (name == '') {
            showToast('Enter A Category Name', 'error');
            return; 
        }

        

        let formData = new FormData();
        formData.append('name', name);
        formData.append('id', id);
        formData.append('_token', '{{ csrf_token() }}'); 

        $.ajax({
            url: '{{ route('admin.category.update') }}', 
            method: 'POST',
            data: formData,
            contentType: false, 
            processData: false, 
            success: function(response) {
                if (response.status==true) {
                    
                    showToast(response.success, 'success');
                    setTimeout(function() {
                        // Redirect to the list page
                        window.location.href = '/admin/category/list';  
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



