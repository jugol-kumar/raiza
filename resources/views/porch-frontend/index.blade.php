@extends('frontend.layouts.app')

@section('content')
    {{-- Categories , Sliders . Today's deal --}}
    <div class="home-banner-area pt-0 sm_d_none">
        <div class="container-fluid pl-0 pr-0">
            <div class="row gutters-10 position-relative">
                @php
                    $num_todays_deal = count(filter_products(\App\Product::where('published', 1)->where('todays_deal', 1 ))->get());
                    $featured_categories = \App\Category::where('featured', 1)->get();
                @endphp
                <div class="col-lg-12">
                    @if (get_setting('home_slider_images') != null)
                        <div class="aiz-carousel dots-inside-bottom mobile-img-auto-height" data-arrows="false"
                             data-dots="{{ get_setting('show_slider_dots') == 'on' ? 'true' : 'false' }}" data-autoplay="false" data-infinite="true">
                            @php $slider_images = json_decode(get_setting('home_slider_images'), true);  @endphp
                            @foreach ($slider_images as $key => $value)
                                    <div class="carousel-box single_full_slider"  style="background-image: url('{{ uploaded_asset($slider_images[$key])  }}') !important;">
                                        <div class="common_shadow">
                                            <a href="#">
                                                <div class="slider_content d-flex align-items-center justify-content-center flex-column min_h_350">
                                                    <h3>{{  json_decode(get_setting('home_slider_title'), true)[$key]  }}</h3>
                                                    <div class="first_section_slider_content">
                                                        ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                                                    </div>
                                                    <div class="middle_section_slider_content d-flex align-items-center justify-content-center">
                                                        @foreach(json_decode(json_decode( get_setting('home_slider_content'), true )[$key], true) as $count => $value)
                                                            <div class="single_slider_content_counter text-center">
                                                                <h3 class="slider_count">{{json_decode(json_decode( get_setting('home_slider_count'), true )[$key], true)[$count]['value']}}</h3>
                                                                <p class="slider_content_text">{{ $value['value'] }} </p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="last_section_slider_content">
                                                        ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                                                    </div>
                                                    <button class="btn rounded-0 px-5 my-3 text-white bg-button-colur">{{  json_decode(get_setting('home_slider_button_text'), true)[$key]  }}</button>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>



    @if ( get_setting('top10_categories') !=  null )
        <div class="container mb-5">
            <div class="py-md-1 py-0">
                <div class="container d-none d-md-block">
                    <div class="d-flex justify-content-between">
{{--                        {{ dd(json_decode(get_setting('top10_categories'), true)) }}--}}
                        <ul class="list-inline mb-0 pl-0 mobile-hor-swipe text-left d-flex align-items-center justify-content-center w-100">
				            @foreach (json_decode(get_setting('top10_categories'), true) as $key => $value)
                                @php $category = \App\Category::find($value); @endphp
                                <li class="list-inline-item mr-0">
                                    <a href="{{ route('products.category', $category->slug) }}"
                                       class="text-matt opacity-100 fs-16 px-3 py-2 d-inline-block fw-600 hov-opacity-80">
                                        {{ translate($category->name) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif


    {{-- Banner section 1 --}}
    @if (get_setting('home_banner1_images') != null)
        <div class="mb-4">
            <div class="container">
                <div class="row gutters-10">
                    @php
                        $banner_1_imags = json_decode(get_setting('home_banner1_images'));
                    @endphp
                    @foreach ($banner_1_imags as $key => $value)
                        <div class="col-xl-2 col-md-2 col-sm-6 col-6">
                            <div class="mb-3 mb-lg-0">
                                <a href="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}"
                                   class="d-block text-reset">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                         data-src="{{ uploaded_asset($banner_1_imags[$key]) }}"
                                         alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Flash Deal --}}
    @php
        $flash_deal = \App\FlashDeal::where('status', 1)->where('featured', 1)->first();
    @endphp
    @if($flash_deal != null && strtotime(date('Y-m-d H:i:s')) >= $flash_deal->start_date && strtotime(date('Y-m-d H:i:s')) <= $flash_deal->end_date)
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="d-flex flex-wrap align-items-baseline">
                        <h3 class="h5 fw-700 mb-0">
                            <span class="pb-3 d-inline-block">{{ translate('Daily Deals') }}</span>
                        </h3>
                        <div class="aiz-count-down ml-auto align-items-center mr-5 mb-2"
                             data-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                        <a href="{{ route('flash-deal-details', $flash_deal->slug) }}"
                           class="mr-0 btn bg-matt text-white btn-sm shadow-md w-100 w-md-auto">{{ translate('VIEW ALL') }}</a>
                    </div>
                    <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5"
                         data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'
                         data-infinite='true'>
                        @foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product)
                            @php
                                $product = \App\Product::find($flash_deal_product->product_id);
                            @endphp
                            @if ($product != null && $product->published != 0)
                                <div class="carousel-box">
                                    <div
                                        class="aiz-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                                        <div class="position-relative">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block">
                                                <img
                                                    class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                    alt="{{  $product->getTranslation('name')  }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                >
                                            </a>
                                            <div class="absolute-top-right aiz-p-hov-icon">
                                                <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})"
                                                   data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}"
                                                   data-placement="left">
                                                    <i class="la la-heart-o"></i>
                                                </a>
                                                <a href="javascript:void(0)" onclick="addToCompare({{ $product->id }})"
                                                   data-toggle="tooltip" data-title="{{ translate('Add to compare') }}"
                                                   data-placement="left">
                                                    <i class="las la-sync"></i>
                                                </a>
                                                <a href="javascript:void(0)"
                                                   onclick="showAddToCartModal({{ $product->id }})"
                                                   data-toggle="tooltip" data-title="{{ translate('Add to cart') }}"
                                                   data-placement="left">
                                                    <i class="las la-shopping-cart"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="p-md-3 p-2 text-left">
                                            <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                                <a href="{{ route('product', $product->slug) }}"
                                                   class="d-block text-reset">{{  $product->getTranslation('name')  }}</a>
                                            </h3>
                                            {{-- <div class="rating rating-sm mt-1">
                                                {{ renderStarRating($product->rating) }}
                                            </div> --}}
                                            <div class="fs-15">
                                                @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                    <del
                                                        class="fw-600 opacity-50 mr-1">{{ home_base_price($product->id) }}</del>
                                                @endif
                                                <span
                                                    class="fw-700 text-primary">{{ home_discounted_base_price($product->id) }}</span>
                                            </div>
                                            @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                                                <div
                                                    class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                                    {{ translate('Club Point') }}:
                                                    <span class="fw-700 float-right">{{ $product->earn_point }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- fetured category section start here--}}
    @if (get_setting('categories_products') != null)
        <div class="mb-4 mt-5 mt-sm-0 x_sm_category">
            <div class="container-fluid pl-5 pr-5 mt_0">
                <h3 class="font-weight-bolder text-danger mb-4 fs-20">Featured Category</h3>
                <div class="row gutters-10">
                    @foreach (json_decode(get_setting('categories_products'), true) as $key => $value)
                        @php $category = \App\Category::find($value); @endphp
                        <div class="col-md-2 col-4 col-sm-2">
                            <a href="" class="d-block text-reset">
                                <div class="card shadow-none bg-transparent border-0">
                                    <div class="card-body p-0">
                                        <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                             data-src="{{ uploaded_asset($category->banner)}}"
                                             alt="{{ env('APP_NAME') }} promo"
                                             class="img-fluid lazyload min-h-215 image-default">
                                        <p class="text-center font-weight-bold m-0 py-1 bg-transparent">{{ $category->name }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    {{--  end fetured category section herer  --}}

{{--    complated --}}

    {{-- Brand Shop Section Start--}}

        <div class="mb-4 mb-sm-0 mt-5 mt-sm-0 x_sm_category">
            <div class="container-fluid pl-5 pr-5 mt_0">
                <h3 class="font-weight-bolder text-danger mb-4 fs-20">Brand Shop</h3>
                <div class="row gutters-10">
                    @foreach(\App\Brand::limit(18)->get() as $key => $brand)
                        <div class="col-md-1 col-4 col-sm-2 min_size_for_desktop single_category_card_hover">
                            <a href="{{ route('products.brand', $brand->slug) }}" class="d-block text-reset">
                                <div class="card shadow-none bg-transparent border-0">
                                    <div class="card-body p-0">
                                        <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                             data-src="{{ uploaded_asset($brand->logo) }}"
                                             alt="{{ env('APP_NAME') }} promo"
                                             class="img-fluid lazyload min-h-130 image-default">
                                    </div>
                                    <div
                                        class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center bg-gray-900 opacity-0 product_hover">
                                        <p class="text-white font-weight-bolder">{{ $brand->getTranslation('name')   }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    {{--  Brand Shop Section End  --}}

    {{--    Who can join with PROCH section starting here  --}}
    <div class="mb-4">
        <div class="container">
            <h3 class="font-weight-bolder text-danger my-5 x_sm_category text-center sm_text_20 fs-20">Who can join with PROCH</h3>
            <div class="row gutters-10 x_text_center">
               @if(json_decode(get_setting('home_categories'), true) != null)
                    @forelse (json_decode(get_setting('home_categories'), true) as $key => $value)
                        @php $category = \App\Category::find($value); @endphp
                        <a href="{{ route('products.category', $category->slug) }}" class="text-reset link-font-size x_fs_12">
                            <p class="font-weight-bolder">{{ $category->name ?? "" }}</p>
                        </a>
                        @if(!$loop->last)
                            <span class="mx-1 slas-font-size x_fs_12">/</span>
                        @endif
                    @empty
                        <small>No have category</small>
                    @endforelse
                @else
                    <small>No have Category</small>
                @endif


                <a href="{{ route('user.registration') }}" class="btn btn-block btn-danger text-center fw-600 link-font-size">Join Us</a>
            </div>
        </div>
    </div>
    {{--    Who can join with PROCH section starting here  --}}



    @if (get_setting('home_banner3_images') != null)
        <div class="mb-4">
            <div class="container">
                <div class="row gutters-10">
                    @php $banner_3_imags = json_decode(get_setting('home_banner3_images')); @endphp
                    @foreach ($banner_3_imags as $key => $value)
                        <div class="col">
                            <div class="mb-3 mb-lg-0">
                                <a href="{{ json_decode(get_setting('home_banner3_links'), true)[$key] }}"
                                   class="d-block text-reset ">{{-- class: image_hover_gless --}}
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                         data-src="{{ uploaded_asset($banner_3_imags[$key]) }}"
                                         alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload ">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif






    {{-- Design idea section starting here  --}}
        <div class="mb-4">
            <div class="container-fluid pl-5 pr-5">
                <h3 class="font-weight-bolder text-matt my-5 text-center x_sm_category fs-20">Design Idea</h3>
                <div class="row gutters-10 mt-5rem">
                    @foreach( App\Blog::with('category')->where('status', 1)->orderBy('created_at', 'desc')->take(4)->get() as $key => $blog)
                        <div class="col-md-3 col-sm-2 single_category_card px-4">
                        <div class="mb-3 mb-lg-0 single_category_card_hover">
                            <a href="{{ url("blog").'/'. $blog->slug }}" class="d-block text-reset">
                                <div class="card shadow-none bg-transparent border-0 mb-0">
                                    <div class="card-body p-0">
                                        <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                             data-src="{{  uploaded_asset($blog->banner) }}"
                                             alt="{{ env('APP_NAME') }} promo"
                                             class="img-fluid lazyload min-h-250 image-default">
                                    </div>
                                    <div
                                        class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center bg-gray-900 opacity-0 product_hover">
{{--                                        <p class="text-white font-weight-bolder">{{ json_decode(get_setting('home_blog_names'), true)[$key] }}</p>--}}
                                    </div>
                                </div>
                                <p class="text-center fw-600 fs-20">{{ $blog->category->category_name }}</p>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    {{-- Design idea section starting here  --}}






    {{--    fetured product section   --}}
    {{--    <div id="section_featured">--}}

    {{--    </div>--}}




    {{--    Best Selling  --}}
    {{--    <div id="section_best_selling">--}}

    {{--    </div>--}}



    {{-- Category wise Products --}}
    {{-- <div id="section_home_categories">

    </div> --}}

    {{-- Classified Product --}}
    {{--    @if(\App\BusinessSetting::where('type', 'classified_product')->first()->value == 1)--}}
    {{--        @php--}}
    {{--            $classified_products = \App\CustomerProduct::where('status', '1')->where('published', '1')->take(10)->get();--}}
    {{--        @endphp--}}
    {{--        @if (count($classified_products) > 0)--}}
    {{--            <section class="mb-4">--}}
    {{--                <div class="container">--}}
    {{--                    <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">--}}
    {{--                        <div class="d-flex align-items-baseline">--}}
    {{--                            <h3 class="h5 fw-700 mb-0">--}}
    {{--                                <span class="pb-3 d-inline-block">{{ translate('Classified Ads') }}</span>--}}
    {{--                            </h3>--}}
    {{--                            <a href="{{ route('customer.products') }}"--}}
    {{--                               class="ml-auto mr-0 btn bg-matt text-white btn-sm shadow-md">{{ translate('VIEW ALL') }}</a>--}}
    {{--                        </div>--}}
    {{--                        <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5"--}}
    {{--                             data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'--}}
    {{--                             data-infinite='true'>--}}
    {{--                            @foreach ($classified_products as $key => $classified_product)--}}
    {{--                                <div class="carousel-box">--}}
    {{--                                    <div--}}
    {{--                                        class="aiz-card-box border border-light rounded hov-shadow-md my-2 has-transition">--}}
    {{--                                        <div class="position-relative">--}}
    {{--                                            <a href="{{ route('customer.product', $classified_product->slug) }}"--}}
    {{--                                               class="d-block">--}}
    {{--                                                <img--}}
    {{--                                                    class="img-fit lazyload mx-auto h-140px h-md-210px"--}}
    {{--                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"--}}
    {{--                                                    data-src="{{ uploaded_asset($classified_product->thumbnail_img) }}"--}}
    {{--                                                    alt="{{ $classified_product->getTranslation('name') }}"--}}
    {{--                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"--}}
    {{--                                                >--}}
    {{--                                            </a>--}}
    {{--                                            <div class="absolute-top-left pt-2 pl-2">--}}
    {{--                                                @if($classified_product->conditon == 'new')--}}
    {{--                                                    <span--}}
    {{--                                                        class="badge badge-inline badge-success">{{translate('new')}}</span>--}}
    {{--                                                @elseif($classified_product->conditon == 'used')--}}
    {{--                                                    <span--}}
    {{--                                                        class="badge badge-inline badge-danger">{{translate('Used')}}</span>--}}
    {{--                                                @endif--}}
    {{--                                            </div>--}}
    {{--                                        </div>--}}
    {{--                                        <div class="p-md-3 p-2 text-left">--}}
    {{--                                            <div class="fs-15 mb-1">--}}
    {{--                                                <span--}}
    {{--                                                    class="fw-700 text-primary">{{ single_price($classified_product->unit_price) }}</span>--}}
    {{--                                            </div>--}}
    {{--                                            <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">--}}
    {{--                                                <a href="{{ route('customer.product', $classified_product->slug) }}"--}}
    {{--                                                   class="d-block text-reset">{{ $classified_product->getTranslation('name') }}</a>--}}
    {{--                                            </h3>--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            @endforeach--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </section>--}}
    {{--        @endif--}}
    {{--    @endif--}}



{{--     Banner Section 2--}}
    {{--    --}}{{-- Best Seller --}}
    {{--    @if (\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)--}}
    {{--    <div id="section_best_sellers">--}}

    {{--    </div>--}}
    {{--    @endif--}}
    {{--    --}}
    {{--    --}}
    {{--    --}}
    {{--    --}}
    {{--    <div id="section_best_brands">--}}

    {{--    </div>--}}

    {{--    --}}
    {{--    --}}
    {{--    --}}
    {{--    --}}
    {{--    --}}
    {{--    --}}
    {{--    --}}


    {{-- Top 10 categories and Brands --}}
    {{--    @if (get_setting('categories_products') != null)--}}
    {{--        @php $categories_products = json_decode(get_setting('categories_products')); @endphp--}}
    {{--        @foreach ($categories_products as $key => $value)--}}
    {{--            <section class="mb-4">--}}
    {{--                <div class="container">--}}
    {{--                    @php $category = \App\Category::find($value); @endphp--}}
    {{--                    <div class="row gutters-10">--}}
    {{--                        <div class="col-lg-12">--}}
    {{--                            <div class="row gutters-5">--}}
    {{--                                @if ($category != null)--}}
    {{--                                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-1">--}}
    {{--                                        <div class="position-relative overflow-hidden h-100 bg-red-c">--}}
    {{--                                            <img class="position-absolute left-0 top-0 img-fit h-100"--}}
    {{--                                                 src="{{ uploaded_asset($category->banner) }}" style="opacity: 0.3;"--}}
    {{--                                                 alt="{{ $category->name }}">--}}
    {{--                                            <div class="position-relative">--}}
    {{--                                                <h3 class="h5 fw-700 mb-0 pt-3 text-center">--}}
    {{--                                                    <span--}}
    {{--                                                        class="pb-3 d-inline-block text-white">{{ $category->name }}</span>--}}
    {{--                                                </h3>--}}
    {{--                                                @if(count(\App\Utility\CategoryUtility::get_immediate_children_ids($category->id))>0)--}}
    {{--                                                    <ul class="list-unstyled mb-2">--}}
    {{--                                                        @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category->id) as $ids)--}}
    {{--                                                            @php--}}
    {{--                                                                $subcat = \App\Category::find($ids);--}}
    {{--                                                            @endphp--}}
    {{--                                                            <li class="text-center mt-2 text-white">--}}
    {{--                                                                <a href="{{ route('products.category', $subcat->slug) }}"--}}
    {{--                                                                   class="text-reset fs-16">{{ $subcat->name }}</a>--}}
    {{--                                                            </li>--}}
    {{--                                                        @endforeach--}}
    {{--                                                    </ul>--}}
    {{--                                                @endif--}}
    {{--                                            </div>--}}
    {{--                                        </div>--}}
    {{--                                        <div class="h-100"--}}
    {{--                                             style="background-image: url({{ uploaded_asset($category->banner) }}); background-size: cover; background-position: center center; opacity: 0.5;">--}}
    {{--                                            <h3 class="h5 fw-700 mb-0 pt-3 text-center">--}}
    {{--                                                <span class="pb-3 d-inline-block">{{ $category->name }}</span>--}}
    {{--                                            </h3>--}}
    {{--                                            @if(count(\App\Utility\CategoryUtility::get_immediate_children_ids($category->id))>0)--}}
    {{--                                                <ul class="list-unstyled mb-2">--}}
    {{--                                                    @foreach (\App\Utility\CategoryUtility::get_immediate_children($category->id) as $subcat)--}}
    {{--                                                        <li class="text-center mt-2">--}}
    {{--                                                            <a href="{{ route('products.category', $subcat->slug) }}"--}}
    {{--                                                               class="text-reset">{{ $subcat->name }}</a>--}}
    {{--                                                        </li>--}}
    {{--                                                    @endforeach--}}
    {{--                                                </ul>--}}
    {{--                                            @endif--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                    <div class="col-12 col-lg-9">--}}
    {{--                                        <div--}}
    {{--                                            class="row gutters-5 row-cols-xxl-5 row-cols-xl-2 row-cols-lg-4 row-cols-md-2 row-cols-2">--}}
    {{--                                            @foreach (filter_products(\App\Product::where('published', 1)->whereIn('category_id', \App\Utility\CategoryUtility::get_immediate_children_ids($category->id))->orderBy('created_at', 'desc'))->limit(10)->get() as $key => $product)--}}
    {{--                                                <div class="col mb-3">--}}
    {{--                                                    <div--}}
    {{--                                                        class="aiz-card-box h-100 border border-light rounded shadow-sm hov-shadow-md has-transition bg-white">--}}
    {{--                                                        <div class="position-relative">--}}
    {{--                                                            <a href="{{ route('product', $product->slug) }}"--}}
    {{--                                                               class="d-block">--}}
    {{--                                                                <img--}}
    {{--                                                                    class="img-fit lazyload mx-auto h-160px"--}}
    {{--                                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"--}}
    {{--                                                                    data-src="{{ uploaded_asset($product->thumbnail_img) }}"--}}
    {{--                                                                    alt="{{  $product->getTranslation('name')  }}"--}}
    {{--                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"--}}
    {{--                                                                >--}}
    {{--                                                            </a>--}}
    {{--                                                            <div class="absolute-top-right aiz-p-hov-icon">--}}
    {{--                                                                <a href="javascript:void(0)"--}}
    {{--                                                                   onclick="addToWishList({{ $product->id }})"--}}
    {{--                                                                   data-toggle="tooltip"--}}
    {{--                                                                   data-title="{{ translate('Add to wishlist') }}"--}}
    {{--                                                                   data-placement="left">--}}
    {{--                                                                    <i class="la la-heart-o"></i>--}}
    {{--                                                                </a>--}}
    {{--                                                                <a href="javascript:void(0)"--}}
    {{--                                                                   onclick="addToCompare({{ $product->id }})"--}}
    {{--                                                                   data-toggle="tooltip"--}}
    {{--                                                                   data-title="{{ translate('Add to compare') }}"--}}
    {{--                                                                   data-placement="left">--}}
    {{--                                                                    <i class="las la-sync"></i>--}}
    {{--                                                                </a>--}}
    {{--                                                                <a href="javascript:void(0)"--}}
    {{--                                                                   onclick="showAddToCartModal({{ $product->id }})"--}}
    {{--                                                                   data-toggle="tooltip"--}}
    {{--                                                                   data-title="{{ translate('Add to cart') }}"--}}
    {{--                                                                   data-placement="left">--}}
    {{--                                                                    <i class="las la-shopping-cart"></i>--}}
    {{--                                                                </a>--}}
    {{--                                                            </div>--}}
    {{--                                                        </div>--}}
    {{--                                                        <div class="p-md-3 p-2 text-left">--}}
    {{--                                                            <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">--}}
    {{--                                                                <a href="{{ route('product', $product->slug) }}"--}}
    {{--                                                                   class="d-block text-reset">{{ $product->getTranslation('name') }}</a>--}}
    {{--                                                            </h3>--}}
    {{--                                                            <div class="rating rating-sm mt-1">--}}
    {{--                                                                {{ renderStarRating($product->rating) }}--}}
    {{--                                                            </div>--}}
    {{--                                                            <div class="fs-15">--}}
    {{--                                                                @if(home_base_price($product->id) != home_discounted_base_price($product->id))--}}
    {{--                                                                    <del--}}
    {{--                                                                        class="fw-600 opacity-50 mr-1">{{ home_base_price($product->id) }}</del>--}}
    {{--                                                                @endif--}}
    {{--                                                                <span--}}
    {{--                                                                    class="fw-700 text-primary">{{ home_discounted_base_price($product->id) }}</span>--}}
    {{--                                                            </div>--}}

    {{--                                                            @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)--}}
    {{--                                                                <div--}}
    {{--                                                                    class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">--}}
    {{--                                                                    {{ translate('Club Point') }}:--}}
    {{--                                                                    <span--}}
    {{--                                                                        class="fw-700 float-right">{{ $product->earn_point }}</span>--}}
    {{--                                                                </div>--}}
    {{--                                                            @endif--}}
    {{--                                                        </div>--}}
    {{--                                                    </div>--}}
    {{--                                                </div>--}}
    {{--                                            @endforeach--}}
    {{--                                        </div>--}}
    {{--                                    </div>--}}
    {{--                                @endif--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </section>--}}
    {{--        @endforeach--}}
    {{--    @endif--}}

    {{--    --}}
    {{--    --}}
    {{--    --}}
    {{--    --}}
    {{--    --}}
    {{--    --}}{{-- Top 10 categories and Brands --}}
    {{--    <section class="mb-4">--}}
    {{--        <div class="container">--}}
    {{--            <div class="row gutters-10">--}}
    {{--                @if (get_setting('top10_categories') != null)--}}
    {{--                    <div class="col-lg-12">--}}
    {{--                        <div class="d-flex align-items-baseline">--}}
    {{--                            <h3 class="h5 fw-700 mb-0">--}}
    {{--                                <span class="pb-3 d-inline-block">{{ translate('Top Categories') }}</span>--}}
    {{--                            </h3>--}}
    {{--                            <a href="{{ route('categories.all') }}"--}}
    {{--                               class="ml-auto mr-0 btn bg-matt text-white btn-sm shadow-md">{{ translate('View All') }}</a>--}}
    {{--                        </div>--}}
    {{--                        <div class="row gutters-5">--}}
    {{--                            @php $top10_categories = json_decode(get_setting('top10_categories')); @endphp--}}
    {{--                            @foreach ($top10_categories as $key => $value)--}}
    {{--                                @php $category = \App\Category::find($value); @endphp--}}
    {{--                                @if ($category != null)--}}
    {{--                                    <div class="col-6 col-sm-4 col-md-2 col-lg-2">--}}
    {{--                                        <a href="{{ route('products.category', $category->slug) }}" class="d-block p-3">--}}
    {{--                                            <img--}}
    {{--                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"--}}
    {{--                                                data-src="{{ uploaded_asset($category->banner) }}"--}}
    {{--                                                alt="{{ $category->getTranslation('name') }}"--}}
    {{--                                                class="img-fluid lazyload"--}}
    {{--                                            >--}}
    {{--                                        </a>--}}
    {{--                                        <h2 class="h6 fw-600 text-truncate text-center">--}}
    {{--                                            <a href="{{ route('products.category', $category->slug) }}"--}}
    {{--                                               class="text-reset">{{ $category->getTranslation('name') }}</a>--}}
    {{--                                        </h2>--}}
    {{--                                    </div>--}}
    {{--                                @endif--}}
    {{--                            @endforeach--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                @endif--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $.post('{{ route('home.section.featured') }}', {_token: '{{ csrf_token() }}'}, function (data) {
                $('#section_featured').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.best_selling') }}', {_token: '{{ csrf_token() }}'}, function (data) {
                $('#section_best_selling').html(data);
                AIZ.plugins.slickCarousel();
            });
            // $.post('{{ route('home.section.home_categories') }}', {_token:'{{ csrf_token() }}'}, function(data){
            //     $('#section_home_categories').html(data);
            //     AIZ.plugins.slickCarousel();
            // });

            @if (\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
            $.post('{{ route('home.section.best_sellers') }}', {_token: '{{ csrf_token() }}'}, function (data) {
                $('#section_best_sellers').html(data);
                AIZ.plugins.slickCarousel();
            });
            @endif
            $.post('{{ route('home.section.best_brands') }}', {_token: '{{ csrf_token() }}'}, function (data) {
                $('#section_best_brands').html(data);
                AIZ.plugins.slickCarousel();
            });
        });
    </script>
@endsection
