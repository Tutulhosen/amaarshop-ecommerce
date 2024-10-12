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
                                <h4 class="text-center">Update Your Slider Image</h4>
                            </div>
                        
                            <form>
                                <div class="mb-3">
                                    <label for="imageUpload" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" name="img[]" id="imageUpload" accept="image/*">
                                </div>
                                <div class="mb-3">
                                    <img id="imagePreview" class="image-preview" src="{{asset('images/slider/'.$slider_info->image_name)}}" alt="Image Preview">
                                </div>
                                <button type="button" class="btn btn-primary mr-2" id="slider_update_btn" value="{{$slider_info->id}}">Submit</button>
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
        
        $('#slider_update_btn').on('click', function(){
       
            let id = $(this).val();
            var image = $('#imageUpload')[0].files[0];


            let formData = new FormData();
            formData.append('id', id);
            formData.append('image', image);
            formData.append('_token', '{{ csrf_token() }}'); 

            $.ajax({
                url: '{{ route('admin.slider.update') }}', 
                method: 'POST',
                data: formData,
                contentType: false, 
                processData: false, 
                success: function(response) {
                    if (response.status==true) {
                       
                    
                        showToast(response.success, 'success');
                        setTimeout(function() {
                            // Redirect to the list page
                            window.location.href = '/admin/slider/list';  
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



