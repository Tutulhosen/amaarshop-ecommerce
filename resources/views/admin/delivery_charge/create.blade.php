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
                                <h3 class="text-center">Create  New </h3>
                            </div>
                            <br>
                            <form class="forms-sample" id="myform">
                                <div class="form-group">
                                    <label for="name_en">Title(English) </label>
                                    <input type="text" class="form-control" id="name_en" placeholder="Title(English)">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="name_bn">Title(Bangla) </label>
                                    <input type="text" class="form-control" id="name_bn" placeholder="Title(Bangla)">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="delivery_charge">Delivery Charge </label>
                                    <input type="number" class="form-control" id="delivery_charge" placeholder="Delivery Charge">
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
            let name_en = $('#name_en').val();
            let name_bn = $('#name_bn').val();
            let delivery_charge = $('#delivery_charge').val();
            
                // alert(name);
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
            
            formData.append('_token', '{{ csrf_token() }}'); 

            $.ajax({
                url: '{{ route('admin.delivery.charge.store') }}', 
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
                    
                },
                
            });
        });


    });

</script>

@endsection



