<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 col-12 mb-md-3 mb-2">
                <div id="sing_prod_img_slider" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($product['gallery'] as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('images/galleries/' . $image) }}" class="d-block w-100" alt="">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        
            <div class="col-md-5 mb-3">
                <h2 class="text-capitalize single_prod_title">{{ $product['title'] }}</h2>
                <h3 class="font-weight-bold single_prod_prices">
                    @if($product['discount'])
                        <span style="text-decoration: line-through; color: #555; opacity: .5">৳ {{ $product['price'] }}</span>
                        <span style="color: #0088cc" id="product_price">{{ $product['discount_price'] }}</span>
                    @else
                        <span style="color: #0088cc" id="product_price">৳ {{ $product['price'] }}</span>
                    @endif
                </h3>
                <p class="sku_text"><span>প্রোডাক্ট কোড: </span> <span class="p-0 pr-1">{{ $product['product_code'] }}</span></p>
                {{-- <h4 class="single_prod_in_stock">স্টক : <span class="text-danger">স্টক আউট</span></h4> --}}
        
                <form action="{{route('shop.checkout')}}" method="post">
                    @csrf
                    <input type="hidden" id="product_id" name="product_id" value="{{$product['id']}}">
                    <input type="hidden" id="total_amount" name="total_amount" value="{{ $product['discount'] ? $product['discount_price'] : $product['price'] }}">
                    <input type="hidden" id="product_price_value" value="{{ $product['discount'] ? $product['discount_price'] : $product['price'] }}">
                    
                    <div class="d-flex">
                        <div class="qty-text-div">
                            <span>পরিমান : </span>
                        </div>
                
                        <div class="qty_div">
                            <div class="minus-qty-div">
                                <i class="fa fa-minus" id="qty_minus"></i>
                            </div>
                            <div class="qty-div">
                                <input type="text" name="qty" id="qty" min="1" value="1" readonly>
                            </div>
                            <div class="plus-qty-div">
                                <i class="fa fa-plus" id="qty_plus"></i>
                            </div>
                        </div>
                    </div><br>
                
                    <div class="total_amount">
                        <span>মোট  : </span> <span id="total_price">{{ $product['discount'] ? $product['discount_price'] : $product['price'] }}</span> টাকা
                    </div>
                    
                    
                    <div class="mt-md-3 mt-2">
                        <input type="submit" class="btn px-4 add_cart_btn" name="add_cart" value="কার্ট-এ যোগ করুন">
                    </div>
                </form>
                
        
                
        
               
            </div>
        
            <div class="col-md-3 mb-3">
                <div class="features">
                    <table>
                        <tbody>
                            <tr>
                                <td class="icon"><i class="fa fa-thumbs-up" style="color: #666"></i></td>
                                <td class="text">100% original products</td>
                            </tr>
                            <tr>
                                <td class="icon"><i class="fa fa-money" style="color: #666"></i></td>
                                <td class="text">Pay cash on delivery</td>
                            </tr>
                            <tr>
                                <td class="icon"><i class="fa fa-shopping-cart" style="color: #666; vertical-align: top"></i></td>
                                <td class="text">Delivery within: 2-3 business days</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        
               
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.add_cart_btn').click(function (e) {
            e.preventDefault();
            // Get the product details
            var productId = $('#product_id').val();
            
            var qty = $('#qty').val();
            var price = $('#product_price_value').val();

            // Send AJAX request to add product to cart
            $.ajax({
                url: '{{ route("cart.add") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    qty: qty,
                    price: price
                },
                success: function (response) {
                    if (response.already_in_cart) {
                        // Toaster alert if the product is already in the cart
                        toastr.info('This product is already in your cart!', 'Info');
                    } else if (response.success) {
                        // Get the updated cart count from the response
                        cartCount = response.cart_count;
                        
                        
                        
                        
                        localStorage.setItem('cartCount', cartCount);

                        // Update the cart count display
                        $('#cart-count').text(cartCount);
                        
                    

                        // Toaster alert for successfully adding to cart
                        toastr.success('Product added to cart!', 'Success');

                        
                    }
                },
                error: function (error) {
                    // Toaster alert for any errors
                    toastr.error('Something went wrong. Please try again.', 'Error');
                    console.log(error);
                }
            });
        });

        // Increment quantity
        document.getElementById('qty_plus').addEventListener('click', function () {
            var qty = parseInt(document.getElementById('qty').value);
            qty++;
            document.getElementById('qty').value = qty;
            updateTotalAmount(); // Update total
        });

        // Decrement quantity
        document.getElementById('qty_minus').addEventListener('click', function () {
            var qty = parseInt(document.getElementById('qty').value);
            if (qty > 1) {
                qty--;
                document.getElementById('qty').value = qty;
                updateTotalAmount(); // Update total
            }
        });
    })
</script>
    