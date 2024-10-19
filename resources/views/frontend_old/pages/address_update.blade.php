@extends('frontend.layout.app')

@section('main-content')
<div class="dashboard-container-new">
    <!-- Account Update Form -->
    <div class="form-container-new">
        <h2>Update Account Information</h2>
        <form id="updateForm">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="card" style="padding: 20px;">
                        <div class="card-body">
                            <h2 style="font-size: 24px">Permanent Address</h2>
        
                            <div class="form-group">
                                <label for="division">Division</label>
                                <select name="division" id="division" class="form-control">
                                    <option value="">--select division--</option>
                                    @foreach ($division as $item)
                                        <option value="{{ $item->id }}" {{ $customer_address && $customer_address->per_div == $item->id ? 'selected' : '' }}>
                                            {{ $item->division_name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
        
                            <div class="form-group">
                                <label for="district">District</label>
                                <select name="district" id="district" class="form-control">
                                    @if (!empty($customer_address))
                                        <option value="{{$customer_address->per_dis}}">{{convert_dis_id_to_name($customer_address->per_dis)}}</option>
                                    @else
                                        <option value="">--select district--</option>
                                    @endif
                                    
                                  
                                </select>
                            </div>
        
                            <div class="form-group">
                                <label for="upazila">Upazila</label>
                                <select name="upazila" id="upazila" class="form-control">
                                    @if (!empty($customer_address))
                                        <option value="{{$customer_address->per_upa}}">{{convert_upa_id_to_name($customer_address->per_upa)}}</option>
                                    @else
                                        <option value="">--select upazila--</option>
                                    @endif
                                 
                                </select>
                            </div>
        
                            <div class="form-group">
                                <label for="address">Details</label>
                                <textarea class="form-control" name="address" id="address" cols="30" rows="5">{{ $customer_address ? $customer_address->per_details : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-md-6">
                    <div class="card " style="padding: 20px;">
                        <div class="card-body">
                            <h2 style="font-size: 24px">Present Address</h2>
                            <div style="text-align: left">
                                <input type="checkbox" id="same_as_permanent">
                                <span style="color: green">Same as permanent address</span>
                            </div>
        
                            <div class="form-group">
                                <label for="p_division">Division</label>
                                <select name="p_division" id="p_division" class="form-control">
                                    <option value="">--select division--</option>
                                    @foreach ($division as $item)
                                        <option value="{{ $item->id }}" {{ $customer_address && $customer_address->pre_div == $item->id ? 'selected' : '' }}>
                                            {{ $item->division_name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
        
                            <div class="form-group">
                                <label for="p_district">District</label>
                                <select name="p_district" id="p_district" class="form-control">
                                    @if (!empty($customer_address))
                                        <option value="{{$customer_address->pre_dis}}">{{convert_dis_id_to_name($customer_address->pre_dis)}}</option>
                                    @else
                                        <option value="">--select district--</option>
                                    @endif
                                </select>
                            </div>
        
                            <div class="form-group">
                                <label for="p_upazila">Upazila</label>
                                <select name="p_upazila" id="p_upazila" class="form-control">
                                    @if (!empty($customer_address))
                                        <option value="{{$customer_address->pre_upa}}">{{convert_upa_id_to_name($customer_address->pre_upa)}}</option>
                                    @else
                                        <option value="">--select upazila--</option>
                                    @endif
                                </select>
                            </div>
        
                            <div class="form-group">
                                <label for="p_address">Details</label>
                                <textarea class="form-control" name="p_address" id="p_address" cols="30" rows="5">{{ $customer_address ? $customer_address->pre_details : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <button type="button" id="updateAddressBtn" class="btn">Update Information</button>
        </form>
        
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
          // When the checkbox is clicked
        $('#same_as_permanent').on('change', function() {
            if ($(this).is(':checked')) {
                // Copy division value from permanent to present address
                $('#p_division').val($('#division').val());

                // Trigger the change event for the division to load dependent districts
                $('#p_division').trigger('change');

                // Copy other fields (address only for now, since district and upazila depend on the AJAX)
                $('#p_address').val($('#address').val());

                // After the districts are loaded via AJAX, copy the district
                setTimeout(function() {
                    $('#p_district').val($('#district').val());

                    // Trigger the change event for the district to load dependent upazilas
                    $('#p_district').trigger('change');

                    // After the upazilas are loaded, set the upazila value
                    setTimeout(function() {
                        $('#p_upazila').val($('#upazila').val());
                    }, 500);  // Delay to wait for the upazila to be populated
                }, 500);  // Delay to wait for the district to be populated
            } else {
                // Clear present address fields when checkbox is unchecked
                $('#p_division').val('');
                $('#p_district').val('');
                $('#p_upazila').val('');
                $('#p_address').val('');
            }
        });

    
        // When Division is selected, get the districts
        $('#division, #p_division').on('change', function() {
            // Get the ID of the element that triggered the event
            let division_id = $(this).val();
            
            if (division_id) {
                $.ajax({
                    url: "{{ route('get.district') }}",  // Assuming the same route for both
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        division_id: division_id
                    },
                    success: function(response) {
                        // Clear and populate the corresponding district select box
                        if ($(this).attr('id') === 'division') {
                            $('#district').empty().append('<option value="">--select district--</option>');
                            $.each(response.districts, function(key, value) {
                                $('#district').append('<option value="' + value.id + '">' + value.district_name_en + '</option>');
                            });
                        } else {
                            $('#p_district').empty().append('<option value="">--select district--</option>');
                            $.each(response.districts, function(key, value) {
                                $('#p_district').append('<option value="' + value.id + '">' + value.district_name_en + '</option>');
                            });
                        }
                    }.bind(this)  // Ensure correct `this` inside the success function
                });
            } else {
                // Reset the district select boxes if no division is selected
                if ($(this).attr('id') === 'division') {
                    $('#district').empty().append('<option value="">--select district--</option>');
                } else {
                    $('#p_district').empty().append('<option value="">--select district--</option>');
                }
            }
        });


        // When District is selected, get the upazilas
        $('#district, #p_district').on('change', function() {
            let district_id = $(this).val();

            if (district_id) {
                $.ajax({
                    url: "{{ route('get.upazila') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        district_id: district_id
                    },
                    
                    success: function(response) {
                        // Clear and populate the corresponding district select box
                        if ($(this).attr('id') === 'district') {
                            $('#upazila').empty();
                            $('#upazila').append('<option value="">--select upazila--</option>');
                            $.each(response.upazilas, function(key, value) {
                                $('#upazila').append('<option value="' + value.id + '">' + value.upazila_name_en + '</option>');
                            });
                        } else {
                            $('#p_upazila').empty();
                            $('#p_upazila').append('<option value="">--select upazila--</option>');
                            $.each(response.upazilas, function(key, value) {
                                $('#p_upazila').append('<option value="' + value.id + '">' + value.upazila_name_en + '</option>');
                            });
                        }
                    }.bind(this) 
                });
            } else {
                
                if ($(this).attr('id') === 'district') {
                    $('#upazila').empty().append('<option value="">--select upazila--</option>');
                } else {
                    $('#p_upazila').empty().append('<option value="">--select upazila--</option>');
                }
            }
        });

        $('#updateAddressBtn').on('click', function(e) {
            e.preventDefault();  // Prevent the default form submission
            
            // Collect all form data
            let formData = {
                _token: "{{ csrf_token() }}",  // Include CSRF token for security
                division: $('#division').val(),
                district: $('#district').val(),
                upazila: $('#upazila').val(),
                address: $('#address').val(),
                p_division: $('#p_division').val(),
                p_district: $('#p_district').val(),
                p_upazila: $('#p_upazila').val(),
                p_address: $('#p_address').val(),
            };

            // Send AJAX request to update the address
            $.ajax({
                url: "{{ route('user.address.update') }}",  // Route for update
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Display success message with cancel button
                        toastr.success('Address updated successfully!', '', {
                            closeButton: true,
                            onShown: function() {
                                let cancelButton = document.createElement('button');
                              
                                cancelButton.onclick = function() {
                                    toastr.clear();  // Close toastr notification
                                };

                                // Append cancel button to the notification
                                let toast = document.querySelector('.toast-success');
                                if (toast) {
                                    toast.querySelector('.toast-message').appendChild(cancelButton);
                                }
                            }
                        });
                        setTimeout(function() {
                            window.location.href = "{{ route('user.profile') }}";
                        }, 2000);

                        // Optionally, you can clear or reset the form here
                    } else {
                        // Handle validation errors or server-side issues
                        toastr.error('Failed to update address. Please try again.', '', {
                            closeButton: true,
                            onShown: function() {
                               
                                cancelButton.onclick = function() {
                                    toastr.clear();  // Close toastr notification
                                };

                                // Append cancel button to the error notification
                                let toast = document.querySelector('.toast-error');
                                if (toast) {
                                    toast.querySelector('.toast-message').appendChild(cancelButton);
                                }
                            }
                        });
                    }
                },
                error: function(xhr) {
                    // Handle server error
                    toastr.error('Something went wrong. Please check the form and try again.', '', {
                        closeButton: true
                    });
                }
            });
        });
        
    });
</script>
@endsection