@extends('admin.layout.app')

@section('main-content')
<style>
    * {
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
    
    .form-group {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    
    .form-group input, .form-group select, .form-group textarea {
        flex-basis: 68%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .autocomplete-items {
        position: absolute;
        background: #fff;
        border: 1px solid #ddd;
        z-index: 99;
        width: 50%;
        right: 18%;
        top:50px;
        max-height: 150px;
        overflow-y: auto;
    }
    
    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #ddd;
        display: flex;
        align-items: center;
    }
    
    .autocomplete-items div img {
        width: 50px;
        height: 50px;
        margin-right: 10px;
    }

    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th, table td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }

    table th {
        background-color: #f0f0f0;
    }

    .add-item-btn, .save-btn {
        margin: 20px 0;
        padding: 10px 20px;
        background-color: #5cb85c;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    
    .add-item-btn:hover, .save-btn:hover {
        background-color: #4cae4c;
    }
</style>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="headline">
                    <h3 class="text-center">Add Order</h3>
                </div><br>
                <form action="{{ route('admin.order.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="customer">Customer: <span class="text-danger">*</span></label>
                        <input type="text" id="customer" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Cust. Phone: <span class="text-danger">*</span></label>
                        <input type="text" id="phone" name="phone_number" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address: <span class="text-danger">*</span></label>
                        <input type="text" id="address" name="delivery_address" required>
                    </div>
                    <div class="form-group">
                        <label for="shipping_method">আপনার এরিয়া সিলেক্ট করুন <span class="text-danger">*</span></label>
                        <select name="shipping_method" id="shipping_method" class="form-control" required>
                            <option value="70" selected>ঢাকার ভিতরে</option>
                            <option value="170">ঢাকার বাইরে</option>
                        </select>
                    </div>
                    <!-- Search Product -->
                    <div class="form-group product-select" style="position: relative;">
                        <label for="search_product">Item: </label>
                        <input type="text" id="search_product" placeholder="Type to search..." autocomplete="off">
                        <div class="autocomplete-items"></div>
                    </div>            
                
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
                        <tbody id="cart-body">
                            <!-- Selected products will be dynamically added here -->
                        </tbody>
                    </table>
                
                    <!-- Hidden fields for product IDs and quantities -->
                    <input type="hidden" name="product_ids[]" id="product_ids">
                    <input type="hidden" name="quantities[]" id="quantities">
                    <input type="hidden" name="subtotals[]" id="subtotals">




        
                    <div style="margin-top: 20px;">
                        <button class="save-btn">Submit</button>
                    </div>
                </form> 
            </div>
        </div>
        
        
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Handle form submission
        $('form').on('submit', function(e) {
            updateHiddenFields(); // Ensure hidden fields are updated before submission
        });

        // Handle product search
        $('#search_product').on('input', function() {
            var query = $(this).val();
            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('admin.order.product.search') }}",
                    method: 'GET',
                    data: { query: query },
                    success: function(response) {
                        let suggestions = '';
                        if (response.length > 0) {
                            response.forEach(product => {
                                suggestions += `
                                    <div class="suggestion-item" data-id="${product.id}" data-name="${product.title}" data-price="${product.price}" data-thumbnail="${product.thumbnail}">
                                        <img src="/images/galleries/${product.thumbnail}" alt="${product.title}">
                                        <span>${product.title} - BDT ${product.price}</span>
                                    </div>`;
                            });
                        } else {
                            suggestions = `<div>No products found</div>`;
                        }
                        $('.autocomplete-items').html(suggestions).show();
                    }
                });
            } else {
                $('.autocomplete-items').hide();
            }
        });

        // Handle product selection
        $(document).on('click', '.suggestion-item', function() {
            var productId = $(this).data('id');
            var productName = $(this).data('name');
            var productPrice = $(this).data('price');
            var productThumbnail = $(this).data('thumbnail');

            var row = `
                <tr>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-item" data-id="${productId}">Remove</button>
                    </td>
                    <td>
                        <img src="/images/galleries/${productThumbnail}" width="35" alt="${productName}">
                        ${productName}
                    </td>
                    <td>BDT ${productPrice}</td>
                    <td>
                        <input type="number" name="qty" value="1" min="1" class="form-control qty-input" style="width: 60px;">
                    </td>
                    <td class="subtotal">BDT ${productPrice}</td>
                </tr>
            `;

            $('#cart-body').append(row);
            $('.autocomplete-items').hide();
            $('#search_product').val('');

            updateTotals();
        });

        // Remove product from cart
        $(document).on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
            updateTotals();
        });

        // Update total on quantity change
        $(document).on('input', '.qty-input', function() {
            var qty = $(this).val();
            var price = $(this).closest('tr').find('td:nth-child(3)').text().replace('BDT', '').trim();
            var subtotal = qty * price;
            $(this).closest('tr').find('.subtotal').text('BDT ' + subtotal);

            updateTotals();
        });

        // Update net total, shipping, and grand total
        function updateTotals() {
            var netTotal = 0;
            $('#cart-body tr').each(function() {
                var subtotal = $(this).find('.subtotal').text().replace('BDT', '').trim();
                netTotal += parseFloat(subtotal);
            });

            var shippingCharge = parseFloat($('#shipping_method').val());
            var grandTotal = netTotal + shippingCharge;

            $('#net-total').text('BDT ' + netTotal);
            $('#shipping_charge').text('BDT ' + shippingCharge);
            $('#grand-total').text('BDT ' + grandTotal);
        }

        // Update shipping cost on area change
        $('#shipping_method').on('change', function() {
            updateTotals();
        });

        // Update hidden fields with product IDs and quantities
        function updateHiddenFields() {
            var productIds = [];
            var quantities = [];
            var subtotals = []; // New array for subtotals

            // Loop through each product row
            $('#cart-body tr').each(function() {
                var productId = $(this).find('.remove-item').data('id'); 
                var qty = $(this).find('.qty-input').val(); 
                var subtotal = $(this).find('.subtotal').text().replace('BDT', '').trim(); // Get subtotal

                if (productId && qty && subtotal) {
                    productIds.push(productId);
                    quantities.push(qty); 
                    subtotals.push(subtotal); // Push subtotal to array
                }
            });

            // Join the arrays into comma-separated strings
            $('#product_ids').val(productIds.join(',')); 
            $('#quantities').val(quantities.join(',')); 
            $('#subtotals').val(subtotals.join(',')); // Ensure this is set up as a comma-separated string
        }




    });


</script>
@endsection
