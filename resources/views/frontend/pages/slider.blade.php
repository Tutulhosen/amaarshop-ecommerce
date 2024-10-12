<section>
    <div class="slider">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="home_slider" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($sliders as $index => $item)
                                <li data-target="#home_slider" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                            @endforeach
                        </ol>

                        <div class="carousel-inner">
                            @foreach ($sliders as $index => $item)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('images/slider/' . $item->image_name) }}" class="d-block w-100" alt="{{ $item->alt_text ?? '' }}">
                                </div>
                            @endforeach
                        </div>

                        <!-- Optional controls -->
                        <a class="carousel-control-prev" href="#home_slider" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#home_slider" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
