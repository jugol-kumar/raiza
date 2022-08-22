<header class="@if(get_setting('header_stikcy') == 'on') sticky-top @endif z-1020 bg-white border-bottom shadow-sm pt-30px">



    <div class="position-relative logo-bar-area z-1">
        <div class="container">
            <div class="d-flex align-items-center">

                <div class="col-auto col-xl-2 pl-0 pr-3 d-flex align-items-center">
                    <a class="d-block py-5px mr-3 ml-0" href="{{ route('home') }}">
                        @php
                            $header_logo = get_setting('header_logo');
                        @endphp
                        @if($header_logo != null)
                            <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-60px h-md-60px" height="80">
                        @else
                            <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-60px h-md-80px" height="80">
                        @endif
                    </a>
                </div>
                <div class="d-lg-none ml-auto mr-0">
                    <a class="p-2 d-block text-reset" href="javascript:void(0);" data-toggle="class-toggle" data-target=".front-header-search">
                        <i class="las la-search la-flip-horizontal la-2x"></i>
                    </a>
                </div>

                <div class="flex-grow-1 front-header-search d-flex align-items-center bg-white border border-dark rounded-25">
                    <div class="position-relative flex-grow-1">
                        <form action="{{ route('search') }}" method="GET" class="stop-propagation">
                            <div class="d-flex position-relative align-items-center">
                                <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
                                    <button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>
                                </div>
                                <div class="input-group">
                                    <input type="text" class="border-0 form-control" id="search" name="q" placeholder="{{translate('Search in Islamic Shop Bangladesh')}}" autocomplete="off">
                                    <div class="input-group-append d-none d-lg-block">
                                        <button class="btn btn-transparent" type="submit">
                                            <i class="la la-search la-flip-horizontal fs-18"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100" style="min-height: 200px">
                            <div class="search-preloader absolute-top-center">
                                <div class="dot-loader"><div></div><div></div><div></div></div>
                            </div>
                            <div class="search-nothing d-none p-3 text-center fs-16">

                            </div>
                            <div id="search-content" class="text-left">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-none d-lg-none ml-3 mr-0">
                    <div class="nav-search-box">
                        <a href="#" class="nav-box-link">
                            <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>
                        </a>
                    </div>
                </div>

                <div class="d-none d-lg-block ml-3 mr-0">
                    <div class="fs-14" id="phone">
                        <a href="tel:+88{{ get_setting('contact_phone') }}" class="d-flex align-items-center text-reset">
                            <i class="la la-phone la-2x opacity-80"></i>
                            <span class="flex-grow-1 ml-1">
                                <span class="nav-box-text d-none d-xl-block opacity-70 fs-12">Hotline</span>
                                <span class="nav-box-text font-weight-bold d-none d-xl-block opacity-70">{{ get_setting('contact_phone') }}</span>
                            </span>
                        </a>
                    </div>
                </div>

                {{--
                <div class="d-none d-lg-block  align-self-stretch ml-3 mr-0" data-hover="dropdown">
                    <div class="nav-cart-box dropdown h-100" id="cart_items">
                        @include('frontend.partials.cart')
                    </div>
                </div>

                <div class="d-none d-lg-block ml-3 mr-0">
                    <div class="" id="wishlist">
                        @include('frontend.partials.wishlist')
                    </div>
                </div>
                --}}


                @auth
                    <div class="d-none d-lg-block ml-3 mr-0 fs-14">
                        <div class="" id="auth">
                            <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-reset">
                                <i class="la la-home la-2x opacity-80"></i>
                                <span class="flex-grow-1 ml-1">
                                <span class="nav-box-text d-none d-xl-block opacity-70 font-weight-bold text-uppercase">My Panel</span>
                            </span>
                            </a>
                        </div>
                    </div>
                    <div class="d-none d-lg-block ml-3 mr-0">
                        <div class="" id="auth">
                            <a href="{{ route('logout') }}" class="d-flex align-items-center text-reset">
                                <i class="la la-sign-in la-2x opacity-80"></i>
                                <span class="flex-grow-1 ml-1">
                                <span class="nav-box-text d-none d-xl-block opacity-70 font-weight-bold text-uppercase">Logout</span>
                            </span>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="d-none d-lg-block ml-3 mr-0 fs-14">
                        <div class="" id="auth">
                            <a href="{{ route('user.login') }}" class="d-flex align-items-center text-reset">
                                <i class="la la-user la-2x opacity-80"></i>
                                <span class="flex-grow-1 ml-1">
                                <span class="nav-box-text d-none d-xl-block opacity-70 font-weight-bold">Login</span>
                                <span class="nav-box-text d-none d-xl-block opacity-70 font-weight-bold">Register</span>
                            </span>
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>






    @if ( get_setting('main_header_menu_labels') !=  null )
        <div class="bg-light py-md-1 py-0 border-danger mt-3 border-bottom-10">
            <nav class="navbar navbar-expand-lg navbar-dark d-md-none">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-brand">
                    <p class="font-weight-bold mb-0"><i class="las la-phone"></i> 01639-200002</p>
                </div>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mr-auto">
                        @foreach (json_decode( get_setting('main_header_menu_labels'), true) as $key => $value)
                            <li class="nav-item">
                                <a href="{{ json_decode( get_setting('main_header_menu_links'), true)[$key] }}"
                                   class="nav-link text-matt opacity-100 fs-14 px-3 py-2 d-inline-block fw-600 hov-opacity-80">
                                    {{ translate($value) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </nav>



{{--            header top hover megamenu  --}}

            @php
                $num_todays_deal = count(filter_products(\App\Product::where('published', 1)->where('todays_deal', 1 ))->get());
                $featured_categories = \App\Category::where('featured', 1)->get();

                $navTopCategories = json_decode(get_setting('header_top_nav_categories'));
            @endphp

            @if($navTopCategories)
                <div class="container-fluid bg-light">
                    <div class="row gutters-10 position-relative">

                        @if (count($navTopCategories) > 0)
                            <div class="col-lg-12 aiz-category-menu d-none d-lg-block">
                                <ul class="list-unstyled categories no-scrollbar mb-2 row gutters-5 justify-content-around">
                                    @foreach ($navTopCategories as $key => $category)
                                        @php $category = \App\Category::find($category); @endphp
                                        @if(!$loop->first)
                                            <li class="category-nav-element minw-0 botton-nave-li" data-id="{{ $category->id }}">
                                                <a href="{{ route('products.category', $category->slug) }}"
                                                   class="text-matt opacity-100 fs-14 px-3 py-2 d-inline-block fw-600 hov-opacity-80">
                                                    {{ $category->getTranslation('name') }}
                                                </a>
                                                @if(count(\App\Utility\CategoryUtility::get_immediate_children_ids($category->id))>0)
                                                    <div class="sub-cat-menu c-scrollbar-light rounded shadow-lg p-4">
                                                        <div class="c-preloader text-center absolute-center">
                                                            <i class="las la-spinner la-spin la-3x opacity-70"></i>
                                                        </div>
                                                    </div>
                                                @endif
                                            </li>
                                        @else
                                            <li class="minw-0 botton-nave-li" data-id="{{ $category->id }}">
                                                <a href="{{ route('products.category', $category->slug) }}"
                                                   class="text-matt opacity-100 fs-14 px-3 py-2 d-inline-block fw-600 hov-opacity-80">
                                                    {{ $category->getTranslation('name') }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>

                            <div class="col-12 d-none d-md-block d-lg-none">
                                <div class="aiz-carousel gutters-10 half-outside-arrow"
                                     data-items="5"
                                     data-md-items="5"
                                     data-sm-items="5"
                                     data-arrows='true'
                                     data-infinite='true'
                                >
                                    @foreach ($featured_categories as $key => $category)
                                        <div class="carousel-box">
                                            <div class="aiz-card-box border border-light hov-shadow-md has-transition">
                                                <div class="position-relative">
                                                    <a href="{{ route('products.category', $category->slug) }}" class="d-block">
                                                        {{ $category }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <small class="text-center">No have Selected Category</small>
            @endif

{{--            header top hover megamenu  --}}
        </div>
    @endif


    @if ( get_setting('main_header_menu_labels') ==  null )
        <div class="bg-light py-md-1 py-0 d-none d-md-block">
            <nav class="navbar navbar-expand-lg navbar-dark d-md-none">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-brand">
                    <ul class="list-inline mb-0 pl-0">
                        <li class="list-inline-item mr-0">
                            <a href="{{ route('wishlists.index') }}"
                               class="text-matt opacity-100 fs-14 px-3 py-2 d-inline-block fw-600 hov-opacity-80">
                                {{translate('Wishlist')}}
                            </a>
                        </li>
                        <li class="list-inline-item mr-0">
                            <a href="{{ route('compare') }}"
                               class="text-matt opacity-100 fs-14 px-3 py-2 d-inline-block fw-600 hov-opacity-80">
                                {{translate('Compare')}}
                            </a>
                        </li>
                    </ul>
                </div>


                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mr-auto">
                        @php
                            $featured_categories = \App\Category::where('featured', 1)->get();;
                        @endphp
                        @foreach ($featured_categories as $key => $value)
                            <li class="nav-item">
                                <a href="{{$featured_categories[$key]->slug }}"
                                   class="nav-link text-matt opacity-100 fs-14 px-3 py-2 d-inline-block fw-600 hov-opacity-80">
                                    {{ translate($featured_categories[$key]->name) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </nav>

            <div class="container-fluid pl-0 pr-0 d-none d-md-block">
                <div class="d-flex justify-content-between">
                    <ul class="list-inline mb-0 pl-0 mobile-hor-swipe text-left d-flex align-items-center justify-content-between w-100">
                        @foreach ($featured_categories as $key => $value)
                            <li class="list-inline-item mr-0">
                                <a href="{{ $featured_categories[$key]->slug }}"
                                   class="text-matt opacity-100 fs-14 px-3 py-2 d-inline-block fw-600 hov-opacity-80">
                                    {{ translate($featured_categories[$key]->name) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif



    <div class="home-banner-area pt-0">
        <div class="container-fluid bg-light">
            <div class="row gutters-10 position-relative">
                @php
                    $num_todays_deal = count(filter_products(\App\Product::where('published', 1)->where('todays_deal', 1 ))->get());
                    $featured_categories = \App\Category::where('featured', 1)->get();
                @endphp

                @if (count($featured_categories) > 0)
                    <div class="col-lg-12 aiz-category-menu d-none d-lg-block">
                        <ul class="list-unstyled categories no-scrollbar mb-2 row gutters-5 justify-content-around">
                            @foreach ($featured_categories as $key => $category)
                                <li class="category-nav-element minw-0 botton-nave-li" data-id="{{ $category->id }}">
                                    <a href="{{ route('products.category', $category->slug) }}"
                                       class="text-matt opacity-100 fs-14 px-3 py-2 d-inline-block fw-600 hov-opacity-80">
                                        {{ $category->getTranslation('name') }}
                                    </a>

                                    @if(count(\App\Utility\CategoryUtility::get_immediate_children_ids($category->id))>0)
                                        <div class="sub-cat-menu c-scrollbar-light rounded shadow-lg p-4">
                                            <div class="c-preloader text-center absolute-center">
                                                <i class="las la-spinner la-spin la-3x opacity-70"></i>
                                            </div>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-12 d-none d-md-block d-lg-none">
                        <div class="aiz-carousel gutters-10 half-outside-arrow"
                             data-items="5"
                             data-md-items="5"
                             data-sm-items="5"
                             data-arrows='true'
                             data-infinite='true'
                        >
                            @foreach ($featured_categories as $key => $category)
                                <div class="carousel-box">
                                    <div class="aiz-card-box border border-light hov-shadow-md has-transition">
                                        <div class="position-relative">
                                            <a href="{{ route('products.category', $category->slug) }}" class="d-block">
                                                {{ $category }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>
