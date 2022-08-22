{{-- <section class="bg-white border-top mt-auto">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-lg-3 col-md-6">
                <a class="text-reset border-left text-center p-4 d-block" href="{{ route('terms') }}">
                    <i class="la la-file-text la-3x text-primary mb-2"></i>
                    <h4 class="h6">{{ translate('Terms & conditions') }}</h4>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a class="text-reset border-left text-center p-4 d-block" href="{{ route('returnpolicy') }}">
                    <i class="la la-mail-reply la-3x text-primary mb-2"></i>
                    <h4 class="h6">{{ translate('Return Policy') }}</h4>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a class="text-reset border-left text-center p-4 d-block" href="{{ route('supportpolicy') }}">
                    <i class="la la-support la-3x text-primary mb-2"></i>
                    <h4 class="h6">{{ translate('Support Policy') }}</h4>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a class="text-reset border-left border-right text-center p-4 d-block" href="{{ route('privacypolicy') }}">
                    <i class="las la-exclamation-circle la-3x text-primary mb-2"></i>
                    <h4 class="h6">{{ translate('Privacy Policy') }}</h4>
                </a>
            </div>
        </div>
    </div>
</section> --}}

{{--<section class="bg-light py-5 text-light footer-widget border-top-10 border-danger">--}}
{{--    <div class="container mx-auto">--}}
{{--        <div class="row" id="main_footer_container">--}}
{{--            <div class="col-md-3 offset-1 col-sm-12 offset-sm-0">--}}
{{--                <div class="text-center text-md-left mt-4">--}}
{{--                    <h4 class="text-matt font-weight-bolder fs-20 text-uppercase fw-600">--}}
{{--                        {{ translate('Customer Care') }}--}}
{{--                    </h4>--}}
{{--                    <ul class="margin_left_1o5">--}}
{{--                        <li class="mb-2">--}}
{{--                            <a href="">Help Center</a>--}}
{{--                        </li>--}}
{{--                        <li class="mb-2">--}}
{{--                            <a href="">Return & Refund</a>--}}
{{--                        </li>--}}
{{--                        <li class="mb-2">--}}
{{--                            <a href="">Contact Us</a>--}}
{{--                        </li>--}}
{{--                        <li class="mb-2">--}}
{{--                            <a href="">Terms & Conditions</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-3 col-sm-12">--}}
{{--                <div class="text-center text-md-left mt-4 d-flex align-items-center flex-column position-absolute">--}}
{{--                    <h4 class="text-matt font-weight-bolder fs-20 text-uppercase fw-600">--}}
{{--                        {{ translate('Porch About Porch') }}--}}
{{--                    </h4>--}}
{{--                    <ul class="margin_left_7">--}}
{{--                        <li class="mb-2">--}}
{{--                            <a href="">Digital Payments</a>--}}
{{--                        </li>--}}
{{--                        <li class="mb-2">--}}
{{--                            <a href="">Careers</a>--}}
{{--                        </li>--}}
{{--                        <li class="mb-2">--}}
{{--                            <a href="">Privacy Policy</a>--}}
{{--                        </li>--}}
{{--                        <li class="mb-2">--}}
{{--                            <a href="">Porch App</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-3 col-sm-12">--}}
{{--                <div class="text-center text-md-left mt-4 d-flex align-items-center flex-column position-absolute">--}}
{{--                    <h4 class="text-matt font-weight-bolder fs-20 text-uppercase fw-600">--}}
{{--                        {{ translate('Do Business With Porch') }}--}}
{{--                    </h4>--}}
{{--                    <ul class="margin_left_8">--}}
{{--                        <li class="mb-2">--}}
{{--                            <a href="">Digital Payments</a>--}}
{{--                        </li>--}}
{{--                        <li class="mb-2">--}}
{{--                            <a href="">Careers</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="row d-sm-none" id="footer_payment">--}}
{{--            <div class="col-md-11 margin_left_3o4">--}}
{{--                <ul class="d-flex align-items-center">--}}
{{--                    <li class="list-group text-matt fw-600">Payment Methods</li>--}}
{{--                    <li><img src="{{ asset('assets/img/cards/bkash.png') }}" alt=""></li>--}}
{{--                    <li><img src="{{ asset('assets/img/cards/bankdeposit.jpg') }}" alt=""></li>--}}
{{--                    <li><img src="{{ asset('assets/img/cards/flutterwave.png') }}" alt=""></li>--}}
{{--                    <li><img src="{{ asset('assets/img/cards/nagad.png') }}" alt=""></li>--}}
{{--                    <li><img src="{{ asset('assets/img/cards/shurjoPay.png') }}" alt=""></li>--}}
{{--                    <li><img src="{{ asset('assets/img/cards/sslcommerz.png') }}" alt=""></li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}



<section class="bg-light py-5 text-light footer-widget border-top-10 border-danger">
    <div class="container">
        <div class="row margin_mx_28">
            <div class="col-md-4">
                <div class="text-center text-md-left mt-4">
                    <h4 class="text-matt font-weight-bolder fs-20 text-uppercase fw-600 ml_3">
                        {{ translate('Customer Care') }}
                    </h4>
                    <ul class="margin_left_1o5 footer-list">
                        <li class="mb-2">
                            <a href="{{ url('/help-center') }}">Help Center</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ url('/returnpolicy') }}">Return & Refund</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ url('/help-center') }}">Contact Us</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ url('/terms') }}">Terms & Conditions</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center text-md-left mt-4">
                    <h4 class="text-matt font-weight-bolder fs-20 text-uppercase fw-600 ml_3">
                        {{ translate('Porch About Porch') }}
                    </h4>
                    <ul class="margin_left_1o5 footer-list">
                        <li class="mb-2">
                            <a href="{{ url('/digital-payments') }}">Digital Payments</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ url('/careers') }}">Careers</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ url('/privacypolicy') }}">Privacy Policy</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ url('/porch-app') }}">Porce App</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center text-md-left mt-4">
                    <h4 class="text-matt font-weight-bolder fs-20 text-uppercase fw-600 ml_3">
                        {{ translate('Do Business With Porch') }}
                    </h4>
                    <ul class="margin_left_1o5 footer-list">
                        <li class="mb-2">
                            <a href="{{ url('/sell-on-porch') }}">Sell on Porch</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ url('/help-center') }}">Code of Conduct</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row" id="footer_payment">
            <div class="col-md-12 margin_left_3o4 d-flex align-items-center">
                <div class="list-group text-matt x_sm_mb_4 font-weight-bold fs-24 mr-5">Payment Methods</div>
                <div class="images">
                    <img src="{{ static_asset('assets/img/cards/bkash.png') }}" alt="">
                    <img src="{{ static_asset('assets/img/cards/bankdeposit.jpg') }}" alt="">
                    <img src="{{ static_asset('assets/img/cards/flutterwave.png') }}" alt="">
                    <img src="{{ static_asset('assets/img/cards/nagad.png') }}" alt="">
                    <img src="{{ static_asset('assets/img/cards/shurjoPay.png') }}" alt="">
                    <img src="{{ static_asset('assets/img/cards/sslcommerz.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
















<!-- FOOTER -->
<footer class="pt-3 pb-7 pb-xl-3 bg-white text-matt">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="text-center">
                    <ul class="list-inline mb-0">
                        @if ( get_setting('payment_method_images') !=  null )
                            @foreach (explode(',', get_setting('payment_method_images')) as $key => $value)
                                <li class="list-inline-item">
                                    <img src="{{ uploaded_asset($value) }}" height="30" class="mw-100 h-auto">
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="text-center font-weight-bolder">
                    @php
                        echo get_setting('frontend_copyright_text');
                    @endphp
                </div>
            </div>
        </div>
    </div>
</footer>


<div class="aiz-mobile-bottom-nav d-xl-none fixed-bottom bg-yellow shadow-lg border-top">
    <div class="d-flex justify-content-around align-items-center">
        <a href="{{ route('home') }}" class="text-reset flex-grow-1 text-center py-3 border-right border-success {{ areActiveRoutes(['home'],'bg-soft-primary')}}">
            <i class="las la-campground la-2x"></i>
        </a>
        <a href="{{ route('categories.all') }}" class="text-reset flex-grow-1 text-center py-3 border-right border-success {{ areActiveRoutes(['categories.all'],'bg-soft-primary')}}">
            <span class="d-inline-block position-relative px-2">
                <i class="las la-table la-2x"></i>
            </span>
        </a>
        <a href="{{ route('cart') }}" class="text-reset flex-grow-1 text-center py-3 border-right border-success {{ areActiveRoutes(['cart'],'bg-soft-primary')}}">
            <span class="d-inline-block position-relative px-2">
                <i class="las la-cart-arrow-down la-2x"></i>
                @if(Session::has('cart'))
                    <span class="badge badge-circle badge-primary position-absolute absolute-top-right" id="cart_items_sidenav">{{ count(Session::get('cart'))}}</span>
                @else
                    <span class="badge badge-circle badge-primary position-absolute absolute-top-right" id="cart_items_sidenav">0</span>
                @endif
            </span>
        </a>
        @if (Auth::check())
            @if(isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="text-reset flex-grow-1 text-center py-2">
                    <span class="avatar avatar-sm d-block mx-auto">
                        @if(Auth::user()->photo != null)
                            <img src="{{ custom_asset(Auth::user()->avatar_original)}}">
                        @else
                            <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                        @endif
                    </span>
                </a>
            @else
                <a href="javascript:void(0)" class="text-reset flex-grow-1 text-center py-2 mobile-side-nav-thumb" data-toggle="class-toggle" data-target=".aiz-mobile-side-nav">
                    <span class="avatar avatar-sm d-block mx-auto">
                        @if(Auth::user()->photo != null)
                            <img src="{{ custom_asset(Auth::user()->avatar_original)}}">
                        @else
                            <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                        @endif
                    </span>
                </a>
            @endif
        @else
            <a href="{{ route('user.login') }}" class="text-reset flex-grow-1 text-center py-2">
                <span class="avatar avatar-sm d-block mx-auto">
                    <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                </span>
            </a>
        @endif
    </div>
</div>


@if (Auth::check() && !isAdmin())
    <div class="aiz-mobile-side-nav collapse-sidebar-wrap sidebar-xl d-xl-none z-1035">
        <div class="overlay dark c-pointer overlay-fixed" data-toggle="class-toggle" data-target=".aiz-mobile-side-nav" data-same=".mobile-side-nav-thumb"></div>
        <div class="collapse-sidebar bg-white">
            @include('frontend.inc.user_side_nav')
        </div>
    </div>
@endif
