<section>
    <div class="hot-deals">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hot-deals-inner-wrapper">
                        <div class="row mb-3">
                            <div class="col-md-6 col-6">
                                <div class="hot-deals-gif">
                                    <img src="{{ asset('frontend/frontEnd/images/hot-deal-logo.gif') }}" alt="">
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="all-hot-deals-btn text-right mt-2">
                                    <a href="{{route('frontend.category.page', 4)}}">সকল হট ডিল <i class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <!-- First Carousel -->
                        <div class="owl-carousel mb-3">
                            
                            @foreach($hot_deal->slice(0, ceil($hot_deal->count() / 2)) as $deal)
                                <div class="hot-deals-product">
                                    <a href="{{ route('frontend.single.product.page', $deal['id']) }}">
                                        <div class="discount">
                                            <div class="discount-wrapper">
                                                <img src="{{ asset('frontend/frontEnd/images/flash-deal-percentage.png') }}" alt="">
                                                <span>{{ $deal['percent'] }}%</span> <br>
                                                <span>ছাড়</span>
                                            </div>
                                        </div>
                                        <p class="float_price">৳ {{ $deal['discount_price'] }}</p>
                                        <img src="{{asset('images/galleries/'.$deal['thumbnail'])}}">
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <!-- Second Carousel -->
                        <div class="owl-carousel">
                            @foreach($hot_deal->slice(ceil($hot_deal->count() / 2)) as $deal)
                                <div class="hot-deals-product">
                                    <a href="{{ route('frontend.single.product.page', $deal['id']) }}">
                                        <div class="discount">
                                            <div class="discount-wrapper">
                                                <img src="{{ asset('frontend/frontEnd/images/flash-deal-percentage.png') }}" alt="">
                                                <span>{{ $deal['percent'] }}%</span> <br>
                                                <span>ছাড়</span>
                                            </div>
                                        </div>
                                        <p class="float_price">৳ {{ $deal['price'] }}</p>
                                        <img src="{{asset('images/galleries/'.$deal['thumbnail'])}}">
                                    </a>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
