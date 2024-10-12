@extends('frontend.layout.app')

@section('main-content')
<section>
    <div class="category_breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p>
                        <a href="{{ url('/') }}">Home</a>
                        /
                        <a href="javascript:void(0);">Home &amp; Gadgets</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="products-details-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-12 mb-md-3 mb-2">
                    <div id="sing_prod_img_slider" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($single_product_data['gallery'] as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('images/galleries/' . $image) }}" class="d-block w-100" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-5 mb-3">
                    <h2 class="text-capitalize single_prod_title">{{ $single_product_data['title'] }}</h2>
                    <h3 class="font-weight-bold single_prod_prices">
                        @if($single_product_data['discount'])
                            <span style="text-decoration: line-through; color: #555; opacity: .5">৳ {{ $single_product_data['price'] }}</span>
                            <span style="color: #0088cc" id="product_price">{{ $single_product_data['discount_price'] }}</span>
                        @else
                            <span style="color: #0088cc" id="product_price">৳ {{ $single_product_data['price'] }}</span>
                        @endif
                    </h3>
                    <p class="sku_text"><span>প্রোডাক্ট কোড: </span> <span class="p-0 pr-1">{{ $single_product_data['product_code'] }}</span></p>
                    {{-- <h4 class="single_prod_in_stock">স্টক : <span class="text-danger">স্টক আউট</span></h4> --}}

                    <form action="{{route('shop.checkout')}}" method="post">
                        @csrf
                        <input type="hidden" id="product_id" name="product_id" value="{{$single_product_data['id']}}">
                        <input type="hidden" id="total_amount" name="total_amount" value="{{ $single_product_data['discount'] ? $single_product_data['discount_price'] : $single_product_data['price'] }}">
                        <input type="hidden" id="product_price_value" value="{{ $single_product_data['discount'] ? $single_product_data['discount_price'] : $single_product_data['price'] }}">
                        
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
                            <span>মোট  : </span> <span id="total_price">{{ $single_product_data['discount'] ? $single_product_data['discount_price'] : $single_product_data['price'] }}</span> টাকা
                        </div>
                        
                        {{-- <input type="submit" class="btn px-4 order_now_btn order_now_btn_m" name="order_now" value="অর্ডার করুন"> --}}
                        <div class="mt-md-3 mt-2">
                            <input type="submit" class="btn px-4 add_cart_btn" name="add_cart" value="কার্ট-এ যোগ করুন">
                        </div>
                    </form>
                    

                    <div class="mt-md-5 mt-4">
                        <h4>ফোনে অর্ডারের জন্য ডায়াল করুন</h4>
                        <h4 class="font-weight-bold ml-4">
                            <a href="tel:01784116079">
                                <i class="fa fa-phone-square"></i>
                                {{$company_info->company_phone}}
                            </a>
                        </h4>
                    </div>

                    <div class="col-12 mt-3 delivery_details" style="padding: 0">
                        <table class="table" style="color:#08c !important">
                            <tbody>
                                <tr>
                                    <td style="padding-left: 0; border-bottom: 1px solid #ddd;">
                                        হোম ডেলিভারি
                                    </td>
                                    <td style="border-bottom: 1px solid #ddd;">
                                        <b>৳ 90</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 0; border-bottom: 1px solid #ddd;">
                                        হোম ডেলিভারি
                                    </td>
                                    <td style="border-bottom: 1px solid #ddd;">
                                        <b>৳ 110</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h6 class="font-weight-bold text-danger mt-md-3 mt-2">বিকাশ নাম্বার : {{$company_info->company_phone}}</h6>
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

            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-tabs nav-tabs-mod">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">পন্যের বিবরণ</a>
                        </li>
                    </ul>
                    <div class="tab-content tab-content-mod">
                        <div class="tab-pane active">
                            <div>
                                {!! $single_product_data['description'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('frontend.pages.related_product')                        
        
        </div>
    </div>
    
</section>

@endsection


