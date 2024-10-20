@extends('frontend.layout.app')

@section('main-content')
<br>
<section>
    <div class="container">
        <div class="row m-0">
            @if (count($products) > 0)
                @foreach($products as $product)
                    <div class="col-md-2 col-6 main-product">
                        <div class="main-product-inner-wrapper text-center product-item">
                            <a href="{{ route('frontend.single.product.page', $product->id) }}">
                                <img src="{{asset('images/galleries/'.$product->thumbnail)}}" alt="{{ $product->title }}">
                            </a>
                            <?php 
                                $discount_price=$product->price- $product->discount;
                            ?>
                            @if($discount_price < $product->price)
                                <p class="mb-0" style="text-decoration: line-through;color: #b8b8b8">৳ {{ $product->price }}</p>
                                <p class="font-weight-bold mb-0" style="color: #fca204">৳ {{ $discount_price }}</p>
                            @else
                            <br><br>    
                                <p class="font-weight-bold mb-0" style="color: #fca204">৳ {{ $discount_price }}</p>
                            @endif
                                <p class="mb-0 prod_name"><a href="{{ route('frontend.single.product.page', $product->id) }}">{{ $product->title }}</a></p>
                            <form action="" method="post">
                                @csrf
                                <input type="hidden" name="qty" value="1">
                                <a class="quick_view" data-id="{{ $product->id }}">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </a>
                                <input type="submit" data-id="{{ $product->id }}" data-price="{{ $discount_price }}" data-qnt="1" class="btn btn-sm w-100 mb-2 add_cart_btn_direct" name="add_cart" value="কার্ট-এ যোগ করুন">
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="row">
                    <div class="col-12 text-center">
                        <h2 class="text-center">কোনো পণ্য পাওয়া যায়নি।</h2> 
                    </div>
                </div>
            @endif
            
        </div>
    </div> 

    @include('frontend.pages.quick_view')
</section>
@endsection
