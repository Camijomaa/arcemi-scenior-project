@extends('frontend.layouts.master')
@section('title','ARCEMI || HOME PAGE')
@section('main-content')
<!-- Slider Area -->
@if(count($banners)>0)
<section id="Gslider" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        @foreach($banners as $key=>$banner)
        <li data-target="#Gslider" data-slide-to="{{$key}}" class="{{(($key==0)? 'active' : '')}}"></li>
        @endforeach

    </ol>
    <div class="carousel-inner" role="listbox">
        @foreach($banners as $key=>$banner)
        <div class="carousel-item {{(($key==0)? 'active' : '')}}">
            <img class="first-slide" src="{{$banner->photo}}" alt="First slide">
            <div class="carousel-caption d-none d-md-block text-left">
                <h1 class="wow fadeInDown">{{$banner->title}}</h1>
                <p>{!! html_entity_decode($banner->description) !!}</p>
                <a class="btn btn-lg ws-btn wow fadeInUpBig" href="{{route('product-grids')}}" role="button">Shop Now<i class="far fa-arrow-alt-circle-right"></i></i></a>
            </div>
        </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</section>
@endif

<!--/ End Slider Area -->
<!-- Start Small Banner -->
<section class="small-banner section">
    <style>
        .scroll-row {
            display: flex;
            overflow-x: auto;
            gap: 20px;
            padding-bottom: 10px;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none;  /* IE 10+ */
        }

        .scroll-row::-webkit-scrollbar {
            display: none; /* Chrome/Safari/Webkit */
        }

        .scroll-item {
            flex: 0 0 auto;
            width: 300px;
        }

        .single-banner {
            position: relative;
            overflow: hidden;
            height: 100%;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .single-banner:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .single-banner img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .single-banner .content {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.4);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 10px;
            text-align: center;
            padding: 20px;
        }

        .single-banner:hover .content {
            opacity: 1;
        }

        .single-banner .content h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .single-banner .content a {
            background: #fff;
            color: #000;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .single-banner .content a:hover {
            background: #f1f1f1;
        }

        @media (max-width: 768px) {
            .scroll-item {
                width: 80%;
            }

            .single-banner img {
                height: 180px;
            }
        }
    </style>

    <div class="container-fluid">
        <div class="scroll-row">
            @php
                $category_lists = DB::table('categories')->where('status', 'active')->where('is_parent', 1)->limit(10)->get();
            @endphp
            @foreach($category_lists as $cat)
                <div class="scroll-item">
                    <div class="single-banner">
                        @if($cat->photo)
                            <img src="{{ $cat->photo }}" alt="{{ $cat->title }}">
                        @else
                            <img src="https://via.placeholder.com/600x370" alt="Category">
                        @endif
                        <div class="content">
                            <h3>{{ $cat->title }}</h3>
                            <a href="{{ route('product-cat', $cat->slug) }}">Discover Now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- End Small Banner -->



<!-- Start Product Area -->
<div class="product-area section">
    <style>
        /* Ensure all product images are the same size */
        .product-img img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 5px;
        }

        /* Consistent spacing */
        .single-product {
            margin-bottom: 30px;
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 8px;
            background-color: #fff;
            transition: box-shadow 0.3s;
            height: 100%;
        }

        .single-product:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .product-content h3 {
            font-size: 16px;
            margin-top: 10px;
            margin-bottom: 5px;
            height: 40px;
            /* fixed height to align titles */
            overflow: hidden;
        }

        .product-price {
            display: flex;
            align-items: center;
        }

        .product-price del {
            color: #999;
            font-size: 14px;
        }

        /* Grid fix for isotope */
        .isotope-grid {
            display: flex;
            flex-wrap: wrap;
        }

        .isotope-item {
            display: flex;
            flex-direction: column;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Trending Item</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="product-info">
                    <div class="nav-main">
                        <!-- Tab Nav -->
                        <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                            @php
                            $categories = DB::table('categories')->where('status', 'active')->where('is_parent', 1)->get();
                            @endphp
                            @if($categories)
                            <button class="btn" style="background:black; color: white;" data-filter="*">All Products</button>
                            @foreach($categories as $key => $cat)
                            <button class="btn" style="background:none;color:black;" data-filter=".{{ $cat->id }}">{{ $cat->title }}</button>
                            @endforeach
                            @endif
                        </ul>
                        <!--/ End Tab Nav -->
                    </div>

                    <div class="tab-content isotope-grid" id="myTabContent">
                        @if($product_lists)
                        @foreach($product_lists as $key => $product)
                        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ $product->cat_id }}">
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="{{ route('product-detail', $product->slug) }}">
                                        @php
                                        $photo = explode(',', $product->photo);
                                        @endphp
                                        <img class="default-img" src="{{ $photo[0] }}" alt="{{ $product->title }}">
                                        <img class="hover-img" src="{{ $photo[0] }}" alt="{{ $product->title }}">
                                        @if($product->stock <= 0)
                                            <span class="out-of-stock">Sale out</span>
                                            @elseif($product->condition == 'new')
                                            <span class="new">New</span>
                                            @elseif($product->condition == 'hot')
                                            <span class="hot">Hot</span>
                                            @else
                                            <span class="price-dec">{{ $product->discount }}% Off</span>
                                            @endif
                                    </a>
                                    <div class="button-head">
                                        <div class="product-action">
                                            <a data-toggle="modal" data-target="#{{ $product->id }}" title="Quick View" href="#"><i class="ti-eye"></i><span>Quick Shop</span></a>
                                            <a title="Wishlist" href="{{ route('add-to-wishlist', $product->slug) }}"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
                                        </div>
                                        <div class="product-action-2">
                                            <a title="Add to cart" href="{{ route('add-to-cart', $product->slug) }}">Add to cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3><a href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a></h3>
                                    <div class="product-price">
                                        @php
                                        $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                                        @endphp
                                        <span>${{ number_format($after_discount, 2) }}</span>
                                        <del style="padding-left:4%;">${{ number_format($product->price, 2) }}</del>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Product Area -->
{{-- @php
    $featured=DB::table('products')->where('is_featured',1)->where('status','active')->orderBy('id','DESC')->limit(1)->get();
@endphp --}}


<!-- Start Most Popular -->
<div class="product-area most-popular section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Hot Item</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel popular-slider">
                    @foreach($product_lists as $product)
                    @if($product->condition=='hot')
                    <!-- Start Single Product -->
                    <div class="single-product">
                        <div class="product-img">
                            <a href="{{route('product-detail',$product->slug)}}">
                                @php
                                $photo=explode(',',$product->photo);
                                // dd($photo);
                                @endphp
                                <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                {{-- <span class="out-of-stock">Hot</span> --}}
                            </a>
                            <div class="button-head">
                                <div class="product-action">
                                    <a data-toggle="modal" data-target="#{{$product->id}}" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                    <a title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                </div>
                                <div class="product-action-2">
                                    <a href="{{route('add-to-cart',$product->slug)}}">Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                            <div class="product-price">
                                <span class="old">${{number_format($product->price,2)}}</span>
                                @php
                                $after_discount=($product->price-($product->price*$product->discount)/100)
                                @endphp
                                <span>${{number_format($after_discount,2)}}</span>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Most Popular Area -->

<!-- Start Shop Home List -->
<section class="shop-home-list section">
    <style>
        .single-list {
            border: 1px solid #eee;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 10px;
            background: #fff;
            height: 100%;
            transition: box-shadow 0.3s ease;
        }

        .single-list:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .list-image {
            height: 200px;
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .list-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 6px;
        }

        .list-image .buy {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: black;
            color: #fff;
            padding: 8px 10px;
            border-radius: 50%;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .list-image .buy:hover {
            background: #444;
        }

        .content {
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }

        .title {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .price {
            color: #E74C3C;
            font-weight: bold;
        }

        @media screen and (max-width: 768px) {
            .list-image {
                height: 160px;
            }
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
          <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Trending Item</h2>
                </div>
            </div>
        </div>
                <div class="row">
                    @php
                        $product_lists = DB::table('products')->where('status', 'active')->orderBy('id', 'DESC')->limit(6)->get();
                    @endphp
                    @foreach($product_lists as $product)
                        <div class="col-md-4">
                            <!-- Start Single List -->
                            <div class="single-list d-flex flex-column h-100">
                                <div class="d-flex h-100">
                                    <div class="list-image me-3" style="flex: 1;">
                                        @php
                                            $photo = explode(',', $product->photo);
                                        @endphp
                                        <img src="{{ $photo[0] }}" alt="{{ $product->title }}">
                                        <a href="{{ route('add-to-cart', $product->slug) }}" class="buy">
                                            <i class="fa fa-shopping-bag"></i>
                                        </a>
                                    </div>
                                    <div class="content" style="flex: 1;">
                                        <h4 class="title"><a href="#">{{ $product->title }}</a></h4>
                                        <p class="price with-discount">${{ number_format($product->discount, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single List -->
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Home List -->



<!-- Start Shop Services Area -->
<section class="shop-services section home">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-rocket"></i>
                    <h4>Free shiping</h4>
                    <p>Orders over $100</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-reload"></i>
                    <h4>Free Return</h4>
                    <p>Within 30 days returns</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>Sucure Payment</h4>
                    <p>100% secure payment</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-tag"></i>
                    <h4>Best Peice</h4>
                    <p>Guaranteed price</p>
                </div>
                <!-- End Single Service -->
            </div>
        </div>
    </div>
</section>
<!-- End Shop Services Area -->


<!-- Modal -->
@if($product_lists)
@foreach($product_lists as $key=>$product)
<div class="modal fade" id="{{$product->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="row no-gutters">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <!-- Product Slider -->
                        <div class="product-gallery">
                            <div class="quickview-slider-active">
                                @php
                                $photo=explode(',',$product->photo);
                                // dd($photo);
                                @endphp
                                @foreach($photo as $data)
                                <div class="single-slider">
                                    <img src="{{$data}}" alt="{{$data}}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- End Product slider -->
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="quickview-content">
                            <h2>{{$product->title}}</h2>
                            <div class="quickview-ratting-review">
                                <div class="quickview-ratting-wrap">
                                    <div class="quickview-ratting">
                                        {{-- <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="fa fa-star"></i> --}}
                                        @php
                                        $rate=DB::table('product_reviews')->where('product_id',$product->id)->avg('rate');
                                        $rate_count=DB::table('product_reviews')->where('product_id',$product->id)->count();
                                        @endphp
                                        @for($i=1; $i<=5; $i++)
                                            @if($rate>=$i)
                                            <i class="yellow fa fa-star"></i>
                                            @else
                                            <i class="fa fa-star"></i>
                                            @endif
                                            @endfor
                                    </div>
                                    <a href="#"> ({{$rate_count}} customer review)</a>
                                </div>
                                <div class="quickview-stock">
                                    @if($product->stock >0)
                                    <span><i class="fa fa-check-circle-o"></i> {{$product->stock}} in stock</span>
                                    @else
                                    <span><i class="fa fa-times-circle-o text-danger"></i> {{$product->stock}} out stock</span>
                                    @endif
                                </div>
                            </div>
                            @php
                            $after_discount=($product->price-($product->price*$product->discount)/100);
                            @endphp
                            <h3><small><del class="text-muted">${{number_format($product->price,2)}}</del></small> ${{number_format($after_discount,2)}} </h3>
                            <div class="quickview-peragraph">
                                <p>{!! html_entity_decode($product->summary) !!}</p>
                            </div>
                            @if($product->size)
                            <div class="size">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <h5 class="title">Size</h5>
                                        <select>
                                            @php
                                            $sizes=explode(',',$product->size);
                                            // dd($sizes);
                                            @endphp
                                            @foreach($sizes as $size)
                                            <option>{{$size}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="col-lg-6 col-12">
                                                        <h5 class="title">Color</h5>
                                                        <select>
                                                            <option selected="selected">orange</option>
                                                            <option>purple</option>
                                                            <option>black</option>
                                                            <option>pink</option>
                                                        </select>
                                                    </div> --}}
                                </div>
                            </div>
                            @endif
                            <form action="{{route('single-add-to-cart')}}" method="POST" class="mt-4">
                                @csrf
                                <div class="quantity">
                                    <!-- Input Order -->
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                <i class="ti-minus"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="slug" value="{{$product->slug}}">
                                        <input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1">
                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                <i class="ti-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!--/ End Input Order -->
                                </div>
                                <div class="add-to-cart">
                                    <button type="submit" class="btn">Add to cart</button>
                                    <a href="{{route('add-to-wishlist',$product->slug)}}" class="btn min"><i class="ti-heart"></i></a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
<!-- Modal end -->
@endsection

@push('styles')
<!-- <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script>
<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script> -->
<style>
    /* Banner Sliding */
    #Gslider .carousel-inner {
        background: #000000;
        color: black;
    }

    #Gslider .carousel-inner {
        height: 550px;
    }

    #Gslider .carousel-inner img {
        width: 100% !important;
        opacity: .8;
    }

    #Gslider .carousel-inner .carousel-caption {
        bottom: 60%;
    }

    #Gslider .carousel-inner .carousel-caption h1 {
        font-size: 50px;
        font-weight: bold;
        line-height: 100%;
        color: #e5cc52;
    }

    #Gslider .carousel-inner .carousel-caption p {
        font-size: 18px;
        color: black;
        margin: 28px 0 28px 0;
    }

    #Gslider .carousel-indicators {
        bottom: 70px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    /*==================================================================
        [ Isotope ]*/
    var $topeContainer = $('.isotope-grid');
    var $filter = $('.filter-tope-group');

    // filter items on button click
    $filter.each(function() {
        $filter.on('click', 'button', function() {
            var filterValue = $(this).attr('data-filter');
            $topeContainer.isotope({
                filter: filterValue
            });
        });

    });

    // init Isotope
    $(window).on('load', function() {
        var $grid = $topeContainer.each(function() {
            $(this).isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'fitRows',
                percentPosition: true,
                animationEngine: 'best-available',
                masonry: {
                    columnWidth: '.isotope-item'
                }
            });
        });
    });

    var isotopeButton = $('.filter-tope-group button');

    $(isotopeButton).each(function() {
        $(this).on('click', function() {
            for (var i = 0; i < isotopeButton.length; i++) {
                $(isotopeButton[i]).removeClass('how-active1');
            }

            $(this).addClass('how-active1');
        });
    });
</script>
<script>
    function cancelFullScreen(el) {
        var requestMethod = el.cancelFullScreen || el.webkitCancelFullScreen || el.mozCancelFullScreen || el.exitFullscreen;
        if (requestMethod) { // cancel full screen.
            requestMethod.call(el);
        } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
            var wscript = new ActiveXObject("WScript.Shell");
            if (wscript !== null) {
                wscript.SendKeys("{F11}");
            }
        }
    }

    function requestFullScreen(el) {
        // Supports most browsers and their versions.
        var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

        if (requestMethod) { // Native full screen.
            requestMethod.call(el);
        } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
            var wscript = new ActiveXObject("WScript.Shell");
            if (wscript !== null) {
                wscript.SendKeys("{F11}");
            }
        }
        return false
    }
</script>

@endpush