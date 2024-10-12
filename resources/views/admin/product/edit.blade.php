@extends('admin.layout.app')


@section('main-content')
<div class="row">
        
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body" style="border:1px solid green">
            
                <div class="headline">
                    <h3 class="text-center">Product update Form</h3>
                </div><br>
                <form class="forms-sample" id="myform">
                    @csrf
                    <input type="hidden" name="product_id" id="product_id" value="{{$product_list->id}}">
                    <input type="hidden" name="type" id="type" value="{{$type}}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product_code">Product Code</label>
                                <input type="text" class="form-control" id="product_code" value="{{$product_list->product_code}}" placeholder="Product code">
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" value="{{$product_list->title}}" placeholder="Title">
                            </div>
        
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select class="form-control" id="category_id" name="category_id">
                                <option value="">--Select--</option>
                                @foreach ($category as $item)
                                    @if ($product_list->category_id == $item->id)
                                        <?php
                                            echo $selected= 'selected';
                                        ?>
                                    @else
                                        <?php
                                            echo $selected= '';
                                        ?>
                                    @endif
                                    <option value="{{$item->id}}" {{$selected}}>{{$item->name}}</option>
                                @endforeach
                            
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price" value="{{$product_list->price}}" placeholder="price">
                            </div>
                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <input type="number" class="form-control" id="discount" value="{{$product_list->discount}}" placeholder="discount">
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" value="{{$product_list->quantity}}" placeholder="quantity">
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" rows="10">{{$product_list->description}}</textarea>
                            </div>
                           
                        </div>
                        <div class="col-md-6">
                            
                            
                            <div class="mb-3">
                                <label>Thumbnail Image:</label>
                                <label for="imageUpload" class="form-label">Upload Image</label>
                                <input type="file" class="form-control" name="img[]" id="imageUpload" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <img id="imagePreview" class="image-preview" src="{{asset('images/galleries/'.$product_list->thumbnail)}}" alt="Image Preview">
                            </div>
                            
                            
                            
                            <div class="mb-3">
                                <label>Gallery:</label>
                                <label for="multipleImageUpload" class="form-label">Upload Images</label>
                                <input type="file" class="form-control" name="img[]" id="multipleImageUpload" accept="image/*" multiple>
                            </div>
                            
                            <!-- Display previous gallery images -->
                            <div class="mb-3" id="previousImageContainer" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                @foreach ($gallery as $image)
                                <div class="gallery-image" data-image-id="{{ $image->image_name }}">
                                    <img src="{{ asset('images/galleries/' . $image->image_name) }}" alt="Gallery Image" style="width: 100px; height: 100px;">
                                </div>
                                @endforeach
                            </div>
                            
                            <!-- New image previews (when selected) -->
                            <div class="mb-3" id="multipleImagePreviewContainer" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
                            
                            
                             
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3" style="text-align: right">
                            <button class="btn btn-dark">Cancel</button>
                            <button type="button" class="btn btn-primary mr-2" id="product_update_btn" >Submit</button>
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
        
        $('#product_update_btn').on('click', function(){
            
            var product_id = $('#product_id').val();
            var type = $('#type').val();
            var product_code = $('#product_code').val();
            var title = $('#title').val();
            var category_id = $('#category_id').val();
            var description = CKEDITOR.instances['description'].getData()
            var price = $('#price').val();
            var discount = $('#discount').val();
            var quantity = $('#quantity').val();
            var thumbnailImage = $('#imageUpload')[0].files[0]; // Assuming you're uploading a single thumbnail image
            var galleryImages = $('#multipleImageUpload')[0].files; // Assuming you're uploading multiple gallery images
           // Assuming you're uploading multiple gallery images
            
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
            
            if (price == '') {
                showToast('Enter The Product Price', 'error');
                return; 
            }
            // if (thumbnailImage==undefined) {
            //     showToast('Select A Thumbnail Image', 'error');
            //     return; 
            // }
            // if (galleryImages.length == 0) {
            //     showToast('Select Some Gallery Image', 'error');
            //     return; 
            // }

            // Create a FormData object to send data with AJAX
            var formData = new FormData();
            formData.append('product_id', product_id);
            formData.append('type', type);
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
            formData.append('_token', '{{ csrf_token() }}');
           

            $.ajax({
                url: "{{route('admin.product.update')}}", 
                method: 'POST',
                data: formData,
                contentType: false, 
                processData: false, 
                success: function(response) {
                    if (response.status==true) {
                        
                        $("#myform")[0].reset(); 
                        // $('#old_img').show();
                    
                        showToast(response.success, 'success');
                        setTimeout(function() {
                            // Redirect to the list page
                            window.location.href = '/admin/product/list';  
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



