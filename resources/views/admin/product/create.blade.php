@extends('admin.layout.app')


@section('main-content')
   <div class="row">
        
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body" style="border:1px solid green">
                
                    <div class="headline">
                        <h3 class="text-center">Product Form</h3>
                    </div><br>
                    <form class="forms-sample" id="myform">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_code">Product Code</label>
                                    <input type="text" class="form-control" id="product_code" placeholder="Product code">
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" placeholder="Title">
                                </div>
            
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select class="form-control" id="category_id" name="category_id">
                                    <option value="">--Select--</option>
                                    @foreach ($category as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control" id="price" placeholder="price">
                                </div>
                                <div class="form-group">
                                    <label for="discount">Discount</label>
                                    <input type="number" class="form-control" id="discount" placeholder="discount">
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" placeholder="quantity">
                                </div>
                                
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" rows="10"></textarea>
                                </div>
                               
                            </div>
                            <div class="col-md-6">
                                
                                
                                <div class="mb-3">
                                    <label>Thumbnail Image:</label>
                                    <label for="imageUpload" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" name="img[]" id="imageUpload" accept="image/*">
                                </div>
                                <div class="mb-3">
                                    <img id="imagePreview" class="image-preview" src="https://via.placeholder.com/300" alt="Image Preview">
                                </div>
                                
                                <div class="mb-3">
                                    <label>Gallery:</label>
                                    <label for="multipleImageUpload" class="form-label">Upload Images</label>
                                    <input type="file" class="form-control" name="img[]" id="multipleImageUpload" accept="image/*" multiple>
                                </div>
                                
                                <div class="mb-3" id="multipleImagePreviewContainer" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                    <!-- This is where image previews will be displayed -->
                                </div>  
                            </div>
                        </div>
                        

                        <div class="row">
                            <div class="col-md-9"></div>
                            <div class="col-md-3" style="text-align: right">
                                <button class="btn btn-dark">Cancel</button>
                                <button type="button" class="btn btn-primary mr-2" id="product_submit_btn" >Submit</button>
                            </div>
                        </div>
                        
                        
                    </form>
                </div>
            </div>
        </div>
       
   </div>
@endsection
@section('scripts')
    
<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
</script>




<script>
    CKEDITOR.replace('description');

    $(document).ready(function(){
        
        $('#product_submit_btn').on('click', function(){
           
            
            // Gather all input values
            var product_code = $('#product_code').val();
            var title = $('#title').val();
            var category_id = $('#category_id').val();
            var description = CKEDITOR.instances['description'].getData()
            var price = $('#price').val();
            var discount = $('#discount').val();
            var quantity = $('#quantity').val();
            var thumbnailImage = $('#imageUpload')[0].files[0]; // Assuming you're uploading a single thumbnail image
            var galleryImages = $('#multipleImageUpload')[0].files; // Assuming you're uploading multiple gallery images
          
           
            if (product_code == '') {
                showToast('Enter The Product Code', 'error');
                return; 
            }
            if (title == '') {
                showToast('Enter A Product Title', 'error');
                return; 
            }

            if (category_id == '') {
                showToast('Select A Category', 'error');
                return; 
            }
           
            // if (description == '') {
            //     showToast('Enter Some Product Description', 'error');
            //     return; 
            // }
            if (price == '') {
                showToast('Enter The Product Price', 'error');
                return; 
            }
            if (thumbnailImage==undefined) {
                showToast('Select A Thumbnail Image', 'error');
                return; 
            }
            if (galleryImages.length == 0) {
                showToast('Select Some Gallery Image', 'error');
                return; 
            }

            // Create a FormData object to send data with AJAX
            var formData = new FormData();
            formData.append('product_code', product_code);
            formData.append('title', title);
            formData.append('category_id', category_id);
            formData.append('description', description);
            formData.append('price', price);
            formData.append('discount', discount);
            formData.append('quantity', quantity);
            formData.append('thumbnail_image', thumbnailImage);
            for (var i = 0; i < galleryImages.length; i++) {
                formData.append('gallery_images[]', galleryImages[i]);
            }
            formData.append('_token', '{{ csrf_token() }}');

            // Send data using AJAX
            $.ajax({
                url: "{{ route('admin.product.store') }}",
                method: 'POST',
                data: formData,
                contentType: false, 
                processData: false,
                success: function(response) {
                    if (response.status == true) {
                        showToast(response.success, 'success');
                        setTimeout(function() {
                            // Redirect to the list page
                            window.location.href = '/admin/product/list';  
                        }, 1500);
                    }
                },
            });
        });





    });

</script>

@endsection



