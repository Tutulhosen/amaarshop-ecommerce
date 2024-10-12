@extends('frontend.layout.app')

@section('main-content')
<section>
    <!-- Cart Items Section -->
    <div class="main">
        <div class="container-for-cart">

            <section class="cart-items">
                <h1 style="font-size: 2rem; font-weight: 700; color: #333; margin-bottom: 20px;">Shopping Cart</h1>

                <ul role="list" style="border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; padding: 0; margin: 0; list-style: none;">
                    @forelse($cart as $key => $item)
                    <!-- Cart Item -->
                    <!-- Remove Button -->
                    <div class="cart-item-remove">
                        <form action="{{ route('cart.remove', $key) }}" method="post" style="display:inline;">
                            @csrf
                            @method('DELETE')  <!-- This is needed to simulate the DELETE request -->
                            <button type="submit" style="background-color: #f00; color: #fff; border: none; padding: 5px 10px; border-radius:5px">Remove</button>
                        </form>
                    </div>
                    <form action="{{ route('cart.update', $key) }}" method="post">
                        @csrf
                        <input type="hidden" name="cart_id" value="{{ $key }}">
                        <li class="cart-item">
                            <div>
                                <img src="{{asset('images/galleries/'.$item['thumbnail'])}}" alt="Product Image">
                            </div>
                            <div class="cart-item-details">
                                <div class="cart-item-info">
                                    <h3><a href="#" style="text-decoration: none; color: #333;"> {{ $item['title'] }}</a></h3>
                                    <div class="price-quantity-row">
                                        <p>{{ $item['price'] }} BDT</p>
                                        <div class="quantity">
                                            <label for="quantity" style="margin-right: 5px">Quantity</label>
                                            <input value="{{ $item['qty'] }}" id="quantity" name="quantity" type="number" min="1">
                                        </div>
                                    </div>
                                    <div class="cart-item-actions">
                                        <button type="submit">Update Cart</button>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </li>
                    </form>
                    
                    @empty
                        <section>
            
                            <div style="text-align: center; background-color: #ffffff; padding: 50px 50px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); ">
                                <img src="{{asset('frontend/image/empty-cart.png')}}" alt="Empty Cart" style="width: 150px; height: 150px; margin-bottom: 30px;">
                    
                                <h2 style="font-size: 1.5em; color: #333; margin-bottom: 20px;">Your cart is currently empty.</h2>
                    
                                <p style="font-size: 1em; color: #555; margin-bottom: 40px;">Before proceed to checkout you must add some products to your shopping cart. You will find a lot of interesting products on our "Shop Now" page.</p>
                    
                                <a href="{{route('home')}}" style="padding: 12px 30px; background-color: #007bff; color: white; text-decoration: none; border-radius: 8px; font-size: 1.2em; transition: background-color 0.3s ease;">Continue Shopping</a>
                            </div>
                        
                        
                        </section>
                    @endforelse
                </ul>
            </section>
            @if (!empty($cart))
                <!-- Order Summary Section -->
                <section class="order-summary">
                    <h2>Order Summary</h2>
                    <dl>
                        {{-- <div style="display: flex; justify-content: space-between; margin-bottom: 16px;">
                            <dt>Subtotal</dt>
                            <dd>BDT. {{ $subtotal }}</dd>
                        </div> --}}
                        {{-- <div style="border-top: 1px solid #ddd; padding-top: 16px; display: flex; justify-content: space-between; margin-bottom: 16px;">
                            <dt>Discount</dt>
                            <dd>BDT {{ $discount }}</dd>
                        </div> --}}
                        {{-- <div style="border-top: 1px solid #ddd; padding-top: 16px; display: flex; justify-content: space-between; margin-bottom: 16px;">
                            <dt>Delivery Charge</dt>
                            <dd>BDT {{ $shipping }}</dd>
                        </div> --}}
                        <div style="border-top: 1px solid #ddd; padding-top: 16px; display: flex; justify-content: space-between; margin-bottom: 16px;">
                            <dt>Total</dt>
                            <dd>BDT {{ $subtotal}}</dd>
                        </div>
                        <div style="margin-top: 24px;">
                            <a href="{{ route('shop.checkout') }}" class="checkout-button" style="text-decoration: none">Checkout</a>
                        </div>
                    </dl>
                </section>
            @endif
            
        </div>
    </div>
</section>

@endsection
