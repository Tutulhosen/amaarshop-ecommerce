@extends('frontend.layout.app')

@section('main-content')
<section>
    <div class="cart-section" style="text-align: center">
        <div class="container">
            @if (!empty($cart))
            <div class="row">
                <!-- Customer Information Section -->
                <div class="col-md-5 col-12 mb-md-0 mb-4">
                    <div class="card">
                        <h5 class="font-weight-bold card-header">কাস্টমার ইনফরমেশন</h5>
                        <div class="card-body p-2">
                            <p class="text-center">অর্ডারটি কনফার্ম করতে আপনার নাম, ঠিকানা, মোবাইল নাম্বার, লিখে <span class="text-danger">অর্ডার কনফার্ম করুন</span> বাটনে ক্লিক করুন</p>
                            <form action="{{ route('checkout') }}" method="post" id="checkout_form" class="checkout_form">
                                @csrf
                                <input type="hidden" name="shipping_cost" id="shipping_cost" value="90">
                                @foreach ($cart as $item)
                                    <input type="hidden" name="product_ids[]" value="{{ $item['product_id'] }}">
                                    <input type="hidden" name="quantities[]" value="{{ $item['qty'] }}">
                                    <input type="hidden" name="total[]" value="{{ $item['price'] }}">
                                    
                                @endforeach
                                <div class="form-group">
                                    <label for="full_name">আপনার নাম <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="আপনার নাম লিখুন" required="">
                                </div>

                                <div class="form-group">
                                    <label for="customer_phone">আপনার মোবাইল <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="customer_phone" name="phone_number" placeholder="আপনার মোবাইল লিখুন" minlength="11" required="">
                                </div>

                                <div class="form-group">
                                    <label for="customer_address">আপনার ঠিকানা <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="customer_address" name="delivery_address" placeholder="আপনার ঠিকানা লিখুন" required=""></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="shipping_method">আপনার এরিয়া সিলেক্ট করুন <span class="text-danger">*</span></label>
                                    <select name="shipping_method" id="shipping_method" class="form-control" required="">
                                        <option value="70" selected="selected">ঢাকার ভিতরে</option>
                                        <option value="170">ঢাকার বাইরে</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success w-100 mb-2" style="height: 50px" id="conf_order_btn">অর্ডার কনফার্ম করুন</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Order Information Section -->
                <div class="col-md-7 col-12">
                    <div class="card">
                        <h5 class="font-weight-bold card-header">Order Information</h5>
                        <div class="card-body p-2 table-responsive">
                            <table class="cart_table table table-bordered table-striped text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Product Name & Image</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($cart as $key => $item)
                                        <tr>
                                            <!-- Delete Item Form -->
                                            <td>
                                                <form action="{{ route('cart.remove', $key) }}" method="post" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="background-color: red !important" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            
                                            <!-- Product Name and Image -->
                                            <td>
                                                <img src="{{ asset('images/galleries/' . $item['thumbnail']) }}" width="35" alt="">
                                                <a href="#" style="font-size: 14px">{{ $item['title'] }}</a>
                                            </td>
                                            
                                            <!-- Product Price -->
                                            <td>{{ $item['price'] }} BDT</td>
                                            
                                            <!-- Product Quantity -->
                                            <td>
                                                <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" class="form-control qty-input" style="width: 60px;">
                                                <input type="hidden" name="update_product_ids" value="{{ $item['product_id'] }}">
                                               
                                            </td>
                                            
                                            <!-- Subtotal -->
                                            <td>{{ $item['qty'] * $item['price'] }} BDT</td>
                                        </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">
                                            <h3>Your cart is empty</h3>
                                            <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-right">Net Total</th>
                                        <td id="net-total">{{ $subtotal }} BDT</td> 
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">Shipping Cost</th>
                                        <td id="shipping_charge">{{ $shipping }} BDT</td>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">Grand Total</th>
                                        <td id="grand-total">{{ $total }} BDT</td> 
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <div>
                                <a href="{{ route('shop.page') }}" class="btn btn-info btn-sm"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                            </div>
                            
                            <div>
                                <form action="{{ route('cart.clear') }}" method="post" style="display:inline;">
                                    @csrf
                                    <button style="padding: 10px" type="submit" class="btn btn-danger btn-lg">Clear Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
                <tr style="text-align: center; vertical-align: middle;">
                    <td colspan="5">
                        <h3>Your cart is empty</h3>
                        <a href="{{ route('home') }}" class="btn btn-primary" style="margin-top: 15px;">Continue Shopping</a>
                    </td>
                </tr>            
            @endif
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Function to calculate totals
            function calculateTotals() {
                let netTotal = 0;
                $('.cart_table tbody tr').each(function() {
                    let itemSubtotal = parseFloat($(this).find('td:nth-child(5)').text().replace(' BDT', '').trim()); 
                    netTotal += itemSubtotal; // Add it to net total
                });
                
                let shippingCharge = parseFloat($('#shipping_method').val()); // Get the shipping cost
                let grandTotal = netTotal + shippingCharge; // Calculate grand total
                
                // Update the totals in the table
                $('#net-total').text(netTotal + ' BDT');
                $('#shipping_charge').text(shippingCharge + ' BDT');
                $('#grand-total').text(grandTotal + ' BDT');
            }

            $('#shipping_method').on('change', function() {
                calculateTotals(); // Recalculate totals when shipping method changes
            });

            // Event for quantity change
            $('.qty-input').on('change', function() {
                let newQuantity = $(this).val();
                let row = $(this).closest('tr');
                let productId = row.find('input[name="update_product_ids"]').val(); 
             
                // SweetAlert confirmation
                Swal.fire({
                    title: 'Are you sure?',
               
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/cart/update/' + productId, 
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                quantity: newQuantity
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Updated!',
                                    'Cart has been updated successfully.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(response) {
                                Swal.fire(
                                    'Error!',
                                    'There was an error updating your cart.',
                                    'error'
                                );
                            }
                        });
                    } else {
                        $(this).val($(this).siblings('.hidden-qty').val());
                    }
                });
            });


            $('#checkout_form').on('submit', function(e) {
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
