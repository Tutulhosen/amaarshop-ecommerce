
@extends('frontend.layout.app')

@section('main-content')
<section>
    
    <section class="py-md-5">
        <div class="cart-section">
            <div class="container">
                <div class="row py-md-5">
                    <div class="col-12 text-center">
                        <h1 class="mb-md-4" style="color: green;font-weight: bold">Order Place Successfully</h1>
                        <p style="color: green">আপনার অর্ডারটি সফলভাবে সম্পন্ন হয়েছে আমাদের কল সেন্টার থেকে ফোন করে আপনার অর্ডারটি কনফার্ম করা হবে</p>
                        <a href="https://amaarshop.com" class="btn btn-success px-5" style="background-color: green">প্রোডাক্ট বাছাই করুন</a>
                    </div>
                </div>
            </div>
        </div>
    
    
    
</section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $(document).on('click', '.additional-address', function() {
            let location = $('input[name="additional_address"]:checked').val();
            let charge = 0;

            if (location == 'inside') {
                charge = 70;
            } else {
                charge = 120;
            }

            // Update the delivery charge in the UI
            $('#delivery-charge').text('BDT ' + charge);

            // Get the original total value (assuming it's stored in a data attribute or variable)
            let originalTotal = parseFloat($('#total-amount').data('total'));

            // Recalculate the total and round it to the nearest integer
            let newTotal = Math.round(originalTotal + charge);

            // Update the total in the UI without decimals
            $('#total-amount').text('BDT ' + newTotal);
            $('#total').val(newTotal);
        });


        $('#checkout-form').on('submit', function(e) {
            e.preventDefault(); // Prevent form from submitting normally

            // Gather form data
            let formData = $(this).serialize();
           
            
            // AJAX request
            $.ajax({
                url: '{{ route("checkout") }}', 
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val() 
                },
                success: function(response) {
                    // Clear localStorage
                    localStorage.clear();

                    // Show Toastr success notification with a cancel button
                    toastr.options = {
                        "closeButton": true, // Adds the close (X) button
                        "progressBar": true, // Progress bar at the bottom
                        "positionClass": "toast-top-right", // Position of the toaster
                        "onclick": null, // No click handler
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000", // Auto-close after 5 seconds
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut",
                    };

                    // Display success message with a cancel button
                    toastr.success('Order placed successfully!', 'Success', {
                        closeButton: true,
                        tapToDismiss: false, // Disables auto-dismiss when clicked
                        timeOut: 0, // Ensures the toast doesn't disappear automatically
                        extendedTimeOut: 0, // Keeps it until user manually closes
                        onclick: function() {
                            toastr.clear(); // Optional: dismiss toaster on click
                        }
                    });

                    setTimeout(function() {
                        if (response.isCustomerlogin==true) {
                            window.location.href = '{{ route("user.profile") }}';
                        } else {
                            let id =response.id;
                            window.location.href = '{{ route("product.invoice", ":id") }}'.replace(':id', id);
                        }
                    }, 3000);
                },
                error: function(response) {
                    // Handle validation errors or other errors
                    if (response.status === 422) {
                        let errors = response.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            alert(value); // Display error messages (customize as needed)
                        });
                    } else {
                        alert('Something went wrong, please try again.');
                    }
                }
            });
        });
    });
</script>
@endsection

