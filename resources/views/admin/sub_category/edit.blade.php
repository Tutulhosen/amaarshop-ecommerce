@extends('backend.layout.app')


@section('main-content')
<a class="btn btn-success" href="{{route('admin.sub.cat.list')}}">Sub Category List</a>
   <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <h2 class="card-title" style="text-align:center">Sub Categoty Form</h2>
                
                <form class="forms-sample" id="myform">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" value="{{$sub_category_info->name}}" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="category_id">Default select</label>
                        <select class="form-control" id="category_id" name="category_id">
                            <option value="">--Select--</option>
                            
                            @foreach ($category_list as $categories)
                                @if ($sub_category_info->category_id == $categories->id)
                                    <?php
                                        echo $selected= 'selected';
                                    ?>
                                @else
                                    <?php
                                        echo $selected= '';
                                    ?>
                                @endif
                                <option value="{{$categories->id}}" {{$selected}}>{{$categories->name}}</option>
                            @endforeach
                       
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Category Image</label>
                        <input type="file" name="img[]" id="category-image" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                        @if (!empty($sub_category_info->image))
                            <div class="old_img" id="old_img" >
                                <img style="height: 100px; width:100px;object-fit:cover" src="{{asset('images/subcategories/'.$sub_category_info->image)}}" alt="">
                            </div>
                        @endif
                        
                        <div class="img_prev" id="img-preview" style="display: none">
                            <!-- Image preview will be shown here -->
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mr-2" id="sub_cat_update_btn" value="{{$sub_category_info->id}}">Submit</button>
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
        
        $('#sub_cat_update_btn').on('click', function(){
        let name = $('#name').val();
        let id = $(this).val();
        let category_id = $('#category_id').find(":selected").val();
       
        let image = $('#category-image')[0].files[0];

        if (name == '') {
            showToast('Enter A Category Name', 'error');
            return; 
        }

        

        let formData = new FormData();
        formData.append('image', image);
        formData.append('name', name);
        formData.append('id', id);
        formData.append('category_id', category_id);
        formData.append('_token', '{{ csrf_token() }}'); 

        $.ajax({
            url: "{{route('admin.sub.cat.update')}}", 
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



