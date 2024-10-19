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
                                <h3 class="text-center">Update</h3>
                            </div>
                            <br>
                            <form class="forms-sample" id="myform">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Title</label>
                                    <input type="text" class="form-control" id="name" value="{{$top_header_info->title}}" placeholder="Username">
                                </div>
                                <div class="mb-3">
                                    <label for="imageUpload" class="form-label">Upload Fav Icon</label>
                                    <input type="file" class="form-control" name="img[]" id="imageUpload" accept="image/*">
                                </div>
                                <div class="mb-3">
                                    <img style="height: 100px !important; width:100px !important" id="imagePreview" class="image-preview" src="{{asset('images/fav_icon/'.$top_header_info->fav_icon)}}" alt="Image Preview">
                                </div>
                                <br>
                                <button type="button" class="btn btn-success mr-2" id="update_btn" value="{{$top_header_info->id}}">Submit</button>
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
        
        $('#update_btn').on('click', function(){
        let name = $('#name').val();
        let id = $(this).val();
        var image = $('#imageUpload')[0].files[0];

        if (name == '') {
            showToast('Enter A Title', 'error');
            return; 
        }

        

        let formData = new FormData();
        formData.append('name', name);
        formData.append('image', image);
        formData.append('id', id);
        formData.append('_token', '{{ csrf_token() }}'); 

        $.ajax({
            url: '{{ route('admin.top-header.update') }}', 
            method: 'POST',
            data: formData,
            contentType: false, 
            processData: false, 
            success: function(response) {
                if (response.status==true) {
                    
                    showToast(response.success, 'success');
                    setTimeout(function() {
                        // Redirect to the list page
                        window.location.href = '/admin/top-header/list';  
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



