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
                                <h3 class="text-center">Create A New Category</h3>
                            </div>
                            <br>
                            <form class="forms-sample" id="myform">
                                <div class="form-group">
                                    <label for="name">Category Name</label>
                                    <input type="text" class="form-control" id="category" placeholder="Category name">
                                </div>
                                <br>
                                <button type="button" class="btn btn-success mr-2" id="cat_subnit_btn">Submit</button>
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
        
        $('#cat_subnit_btn').on('click', function(){
        let name = $('#category').val();

        if (name == '') {
            showToast('Enter A Category Name', 'error');
            return; 
        }


        let formData = new FormData();
        formData.append('name', name);
        formData.append('_token', '{{ csrf_token() }}'); 

        $.ajax({
            url: '{{ route('admin.category.store') }}', 
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
                
            },
            
        });
    });





    });

</script>

@endsection



