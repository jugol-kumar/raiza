
<section class="slice-sm footer-top-bar bg-white">
    <div class="container sct-inner">
        <div class="row no-gutters">
            <div class="col-lg-3 col-md-6">
                <div class="footer-top-box text-center">
                    <a href="{{ route('custom-pages.show_custom_page', 'sellerpolicy') }}">
                        <i class="la la-file-text"></i>
                        <h4 class="heading-5">{{ translate('Seller Policy') }}</h4>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-top-box text-center">
                    <a href="{{ route('custom-pages.show_custom_page', 'returnpolicy') }}">
                        <i class="la la-mail-reply"></i>
                        <h4 class="heading-5">{{ translate('Return Policy') }}</h4>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-top-box text-center">
                    <a href="{{ route('custom-pages.show_custom_page', 'supportpolicy') }}">
                        <i class="la la-support"></i>
                        <h4 class="heading-5">{{ translate('Support Policy') }}</h4>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-top-box text-center">
                    <a href="{{ route('profile') }}">
                        <i class="la la-dashboard"></i>
                        <h4 class="heading-5">{{ translate('My Profile') }}</h4>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- FOOTER -->
<footer id="footer" class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                @php
                    $footer_logo = get_setting('footer_logo');
                @endphp
                <div class="col-lg-5 col-xl-4 text-center text-md-left">
                    <div class="col">
                        <a href="{{ route('home') }}" class="d-block">
                            @if($footer_logo != null)
                                <img loading="lazy"  src="{{ uploaded_asset($footer_logo) }}" alt="{{ env('APP_NAME') }}" height="44">
                            @else
                                <img loading="lazy"  src="{{ static_asset('frontend/images/logo/logo.png') }}" alt="{{ env('APP_NAME') }}" height="44">
                            @endif
                        </a>
                            {!! get_setting('about_us_description') !!}
                        <div class="d-inline-block d-md-block">
                            <form class="form-inline" method="POST" action="{{ route('subscribers.store') }}">
                                @csrf
                                <div class="form-group mb-0">
                                    <input type="email" class="form-control" placeholder="{{ translate('Your Email Address') }}" name="email" required>
                                </div>
                                <button type="submit" class="btn bg-danger btn-base-1 btn-icon-left">
                                    {{ translate('Subscribe') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 offset-xl-1 col-md-4">
                    <div class="col text-center text-md-left">
                        <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                            {{ translate('Contact Info') }}
                        </h4>
                        <ul class="footer-links contact-widget">
                            <li>
                                <span class="d-block opacity-5">{{ translate('Address') }}:</span>
                                {{ get_setting('contact_address') }}
                            </li>
                            <li>
                                <span class="d-block opacity-5">{{translate('Phone')}}:</span>
                                <span class="d-block">{{ "+88". get_setting('contact_phone') }}</span>
                            </li>
                            <li>
                                <span class="d-block opacity-5">{{translate('Email')}}:</span>
                                <span class="d-block">
                                   <a href="mailto:{{ get_setting('contact_email') }}">{{ get_setting('contact_email') }}</a>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="col text-center text-md-left">
                        <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                            {{ translate('Useful Link') }}
                        </h4>
                        <ul class="list-unstyled customerCare">
                            @if ( get_setting('widget_one_labels') !=  null )
                                @foreach (json_decode( get_setting('widget_one_labels'), true) as $key => $value)
                                    <li class="mb-2">
                                        <a href="{{ json_decode( get_setting('widget_one_links'), true)[$key] }}" class="text-black fw-500 fs-18 text-hov-underline">
                                            {{ $value }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col-md-4 col-lg-2">
                    <div class="col text-center text-md-left">
                        <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                            {{ translate('My Account') }}
                        </h4>

                        <ul class="footer-links">
                            @if (Auth::check())
                                <li>
                                    <a href="{{ route('logout') }}">
                                        {{ translate('Logout') }}
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('user.login') }}">
                                        {{ translate('Login') }}
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('purchase_history.index') }}">
                                    {{ translate('Order History') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('wishlists.index') }}">
                                    {{ translate('My Wishlist') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('orders.track') }}">
                                    {{ translate('Track Order') }}
                                </a>
                            </li>
                            @if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated)
                                <li>
                                    <a href="{{ route('affiliate.apply') }}">{{ translate('Be an affiliate partner')}}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    @if (\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                        <div class="col text-center text-md-left">
                            <div class="mt-4">
                                <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                                    {{ translate('Be a Seller') }}
                                </h4>
                                <a href="{{ route('shops.create') }}" class="btn bg-orange btn-base-1 btn-icon-left">
                                    {{ translate('Apply Now') }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom py-3 sct-color-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="copyright text-center text-md-left">
                        <ul class="copy-links no-margin">
                            <li>
                                © {{ date('Y') }} {!! get_setting('frontend_copyright_text') !!}
                            </li>
                            <li>
                                <a href="{{ route('custom-pages.show_custom_page', 'terms') }}">{{ translate('Terms') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('custom-pages.show_custom_page', 'privacypolicy') }}">{{ translate('Privacy policy') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <ul class="text-center my-3 my-md-0 social-nav model-2">
                        @if ( get_setting('facebook_link') !=  null )
                            <li class="list-inline-item">
                                <a href="{{ get_setting('facebook_link') }}" target="_blank" class="facebook"><i class="la la-facebook-f"></i></a>
                            </li>
                        @endif
                        @if ( get_setting('twitter_link') !=  null )
                            <li class="list-inline-item">
                                <a href="{{ get_setting('twitter_link') }}" target="_blank" class="twitter"><i class="la la-twitter"></i></a>
                            </li>
                        @endif
                        @if ( get_setting('instagram_link') !=  null )
                            <li class="list-inline-item">
                                <a href="{{ get_setting('instagram_link') }}" target="_blank" class="instagram"><i class="la la-instagram"></i></a>
                            </li>
                        @endif
                        @if ( get_setting('youtube_link') !=  null )
                            <li class="list-inline-item">
                                <a href="{{ get_setting('youtube_link') }}" target="_blank" class="youtube"><i class="la la-youtube"></i></a>
                            </li>
                        @endif
                        @if ( get_setting('linkedin_link') !=  null )
                            <li class="list-inline-item">
                                <a href="{{ get_setting('linkedin_link') }}" target="_blank" class="linkedin"><i class="la la-linkedin"></i></a>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="col-md-4">
                    <div class="text-center text-md-right">
                        <ul class="list-inline mb-0 d-flex">
                            @if ( get_setting('payment_method_images') !=  null )
                                @foreach (explode(',', get_setting('payment_method_images')) as $key => $value)
                                    <li class="list-inline-item">
                                        <img src="{{ uploaded_asset($value) }}" style="width: 100%; height: 50px">
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>





<div class="aiz-mobile-bottom-nav d-xl-none fixed-bottom bg-white shadow-lg border-top">
    <div class="d-flex justify-content-around align-items-center">
        <a href="{{ route('home') }}" class="text-reset flex-grow-1 text-center py-3 border-right border-light {{ areActiveRoutes(['home'],'bg-soft-primary')}}">
            <i class="la la-home la-2x"></i>
        </a>
        <a href="{{ route('categories.all') }}" class="text-reset flex-grow-1 text-center py-3 border-right border-light {{ areActiveRoutes(['categories.all'],'bg-soft-primary')}}">
            <span class="d-inline-block position-relative px-2">
                <i class="la la-table la-2x"></i>
            </span>
        </a>
        <a href="{{ route('cart') }}" class="text-reset flex-grow-1 text-center py-3 border-right border-light {{ areActiveRoutes(['cart'],'bg-soft-primary')}}">
            <span class="d-inline-block position-relative px-2">
                <i class="la la-cart-arrow-down la-2x"></i>
                @if(Session::has('cart'))
                    <span class="badge badge-circle badge-warning position-absolute absolute-top-right" id="cart_items_sidenav">{{ count(Session::get('cart'))}}</span>
                @else
                    <span class="badge badge-circle badge-warning position-absolute absolute-top-right" id="cart_items_sidenav">0</span>
                @endif
            </span>
        </a>
        @if (Auth::check())
            <a href="{{ route('dashboard') }}" class="text-reset flex-grow-1 text-center py-2 mobile-side-nav-thumb" data-toggle="class-toggle" data-target=".aiz-mobile-side-nav">
                <span class="avatar avatar-sm d-block mx-auto">
                    @if(Auth::user()->photo != null)
                        <img src="{{ custom_asset(Auth::user()->avatar_original)}}">
                    @else
                        <i class="la la-user la-2x"></i>
                    @endif
                </span>
            </a>
        @else
            <a href="{{ route('user.login') }}" class="text-reset flex-grow-1 text-center py-2">
                <span class="avatar avatar-sm d-block mx-auto">
                            <i class="la la-user la-2x"></i>
                </span>
            </a>
        @endif
    </div>
</div>



