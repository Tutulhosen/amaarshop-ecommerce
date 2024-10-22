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
                                <h3 class="text-center">Update</h3>
                            </div>
                            <br>
                            <form class="forms-sample" id="myform">
                                @csrf
                                <div class="form-group">
                                    <label for="name_en">Title(English)</label>
                                    <input type="text" class="form-control" id="name_en" value="{{$delivery_charge_info->name_en}}" placeholder="Username">
                                </div><br>
                                <div class="form-group">
                                    <label for="name_bn">Title(Bangla)</label>
                                    <input type="text" class="form-control" id="name_bn" value="{{$delivery_charge_info->name_bn}}" placeholder="Username">
                                </div><br>
                                <div class="form-group">
                                    <label for="delivery_charge">Delivery Charge</label>
                                    <input type="text" class="form-control" id="delivery_charge" value="{{$delivery_charge_info->charge}}" placeholder="Username">
                                </div>
                               
                                <br>
                                <button type="button" class="btn btn-success mr-2" id="update_btn" value="{{$delivery_charge_info->id}}">Submit</button>
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
        
        $('#update_btn').on('click', function(){
        let name_en = $('#name_en').val();
        let name_bn = $('#name_bn').val();
        let delivery_charge = $('#delivery_charge').val();
        let id = $(this).val();
        

        if (name_en == '') {
            showToast('Enter A Title In English', 'error');
            return; 
        }
        if (name_bn == '') {
            showToast('Enter A Title In Bangla', 'error');
            return; 
        }
        if (delivery_charge == '') {
            showToast('Enter A Delivery Charge', 'error');
            return; 
        }

        

        let formData = new FormData();
        formData.append('name_en', name_en);
        formData.append('name_bn', name_bn);
        formData.append('delivery_charge', delivery_charge);
        formData.append('id', id);
        formData.append('_token', '{{ csrf_token() }}'); 

        $.ajax({
            url: '{{ route('admin.delivery.charge.update') }}', 
            method: 'POST',
            data: formData,
            contentType: false, 
            processData: false, 
            success: function(response) {
                if (response.status==true) {
                    
                    showToast(response.success, 'success');
                    setTimeout(function() {
                        // Redirect to the list page
                        window.location.href = '/admin/delivery/charge/list';  
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



