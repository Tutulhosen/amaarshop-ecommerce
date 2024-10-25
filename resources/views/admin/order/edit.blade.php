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
                    <h3 class="text-center">Edit Order</h3>
                </div><br>
                <form action="{{ route('admin.order.update.by', $single_order->order_code) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="customer">Customer: <span class="text-danger">*</span></label>
                        <input type="text" id="customer" name="full_name" value="{{ $single_order->full_name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Cust. Phone: <span class="text-danger">*</span></label>
                        <input type="text" id="phone" name="phone_number" value="{{ $single_order->phone_number }}" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address: <span class="text-danger">*</span></label>
                        <input type="text" id="address" name="delivery_address" value="{{ $single_order->delivery_address }}" required>
                    </div>
                    <div class="form-group">
                        <label for="shipping_method">Select Area<span class="text-danger">*</span></label>
                        <select name="shipping_method" id="shipping_method" class="form-control" required>
                            <option value="">--select area--</option>
                            @foreach ($delivery_charge as $item)
                            <option value="{{ $item->charge }}" {{ $single_order->delivery_charge == $item->charge ? 'selected' : '' }}>{{ $item->name_en }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search Product -->
                    <div class="form-group product-select" style="position: relative;">
                        <label for="search_product">Item: </label>
                        <input type="text" id="search_product" placeholder="Type to search..." autocomplete="off">
                        <div class="autocomplete-items"></div>
                    </div>            

                    <!-- Cart Table -->
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
                            @foreach ($order_invoice as $product)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-item" data-id="{{ $product->product_id }}">Remove</button>
                                    </td>
                                    <td>
                                        <img src="/images/galleries/{{ $product->thumbnail }}" width="35" alt="{{ $product->title }}">
                                        {{ $product->title }}
                                    </td>
                                    <td>BDT {{ $product->offer_cost - $product->discount }}</td>
                                    <td>
                                        <input type="number" name="qty" value="{{ $product->products_qty }}" min="1" class="form-control qty-input" style="width: 60px;">
                                    </td>
                                    <td class="subtotal">BDT {{ ($product->offer_cost - $product->discount) * $product->products_qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right">Net Total:</td>
                                <td id="net-total">BDT 0</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">Delivery Charge:</td>
                                <td>
                                    <input type="number" id="delivery-charge" value="{{ $single_order->delivery_charge }}" min="0" class="form-control" style="width: 100px;">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">Discount:</td>
                                <td>
                                    <input type="number" id="discount" value="{{ $single_order->discount }}" min="0" class="form-control" style="width: 100px;">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">Total Sum:</td>
                                <td id="grand-total">BDT 0</td>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <!-- Hidden fields for product IDs and quantities -->
                    <input type="hidden" name="product_ids[]" id="product_ids">
                    <input type="hidden" name="quantities[]" id="quantities">
                    <input type="hidden" name="subtotals[]" id="subtotals">
                    <input type="hidden" name="delivery_charge_hidden" id="delivery_charge_hidden">
                    <input type="hidden" name="discount_hidden" id="discount_hidden">

                    <div style="margin-top: 20px;">
                        <button class="save-btn">Update</button>
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
        // Preload totals when page loads
        updateTotals();

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
                                    <div class="suggestion-item" data-id="${product.id}" data-name="${product.title}" data-price="${product.price-product.discount}" data-thumbnail="${product.thumbnail}">
                                        <img src="/images/galleries/${product.thumbnail}" alt="${product.title}">
                                        <span>${product.title} - BDT ${product.price-product.discount}</span>
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
                </tr>`;
            
            $('#cart-body').append(row);
            $('.autocomplete-items').hide();
            updateTotals();
        });

        // Handle quantity change
        $(document).on('input', '.qty-input', function() {
            var qty = $(this).val();
            var price = $(this).closest('tr').find('td:nth-child(3)').text().replace('BDT ', '');
            var subtotal = qty * price;
            $(this).closest('tr').find('.subtotal').text('BDT ' + subtotal);
            updateTotals();
        });

        // Handle removing item from cart
        $(document).on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
            updateTotals();
        });

        // Handle delivery charge and discount change
        $('#delivery-charge, #discount').on('input', function() {
            updateTotals();
        });

        // Function to update totals
        function updateTotals() {
            var netTotal = 0;
            var productIds = [];
            var quantities = [];
            var subtotals = [];

            // Loop through each cart row and gather data
            $('#cart-body tr').each(function() {
                var productId = $(this).find('.remove-item').data('id'); // Get the product ID
                var qty = $(this).find('.qty-input').val(); // Get the quantity
                var price = parseFloat($(this).find('td:nth-child(3)').text().replace('BDT ', '')); // Get the price
                var subtotal = qty * price; // Calculate subtotal

                // Add to the hidden fields arrays
                productIds.push(productId);
                quantities.push(qty);
                subtotals.push(subtotal);

                netTotal += subtotal; // Add to the total
                $(this).find('.subtotal').text('BDT ' + subtotal); // Update subtotal in the table
            });

            // Update the net total
            $('#net-total').text('BDT ' + netTotal);

            // Get delivery charge and discount
            var deliveryCharge = parseFloat($('#delivery-charge').val()) || 0;
            var discount = parseFloat($('#discount').val()) || 0;

            // Calculate grand total
            var grandTotal = netTotal + deliveryCharge - discount;
            $('#grand-total').text('BDT ' + grandTotal);

            // Populate hidden inputs
            $('#product_ids').val(productIds.join(',')); // Convert array to comma-separated string
            $('#quantities').val(quantities.join(','));
            $('#subtotals').val(subtotals.join(','));
            $('#delivery_charge_hidden').val(deliveryCharge);
            $('#discount_hidden').val(discount);
        }

    });
</script>
@endsection
