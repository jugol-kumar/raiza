@extends('frontend.layouts.app')

@section('content')
    <section class="gry-bg py-5">
        <div class="profile">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 mx-auto">
                        <div class="card">
                            <div class="text-center pt-4">
                                <h1 class="h4 fw-600">
                                    {{ translate('Login to your account.')}}
                                </h1>
                            </div>

                            <div class="px-4 py-3 py-lg-4">
                                <div class="">
                                    <form class="form-default" role="form" action="{{ route('user.login.submit') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <div class="form-group phone-form-group mb-1">
                                                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                                    <input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="{{ translate('01xxxxxxxxx')}}" name="phone" id="phone">
                                                @endif
                                            </div>
                                            <div class="form-group email-form-group mb-1 d-none">
                                                <input style="margin-bottom: 1rem;" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                                                <input type="password" class="form-control" placeholder="{{ translate('Password')}}" name="password" id="password">
                                            </div>
                                        </div>
                                        <div class="form-group text-right">
                                            <button class="btn btn-link p-0 opacity-50 text-reset" type="button" onclick="toggleEmailPhone(this)">{{ translate('Use Email Instead') }}</button>
                                        </div>
                                        <div class="mb-5">
                                            <button type="submit" class="btn btn-primary bg-matt btn-block fw-600">{{  translate('Login') }}</button>
                                        </div>
                                    </form>

                                    @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                        <div class="separator mb-3">
                                            <span class="bg-white px-3 opacity-60">{{ translate('Or Login With')}}</span>
                                        </div>
                                        <ul class="list-inline social colored text-center mb-5">
                                            @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                                <li class="list-inline-item">
                                                    <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                                        <i class="lab la-facebook-f"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                                <li class="list-inline-item">
                                                    <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                                        <i class="lab la-google"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            @if (\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                                <li class="list-inline-item">
                                                    <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                                        <i class="lab la-twitter"></i>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <p class="text-muted mb-0 fs-14">{{ translate('Dont have an account?')}}</p>
                                    <a class="fs-16" href="{{ route('user.registration') }}">{{ translate('Register Now')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        var isPhoneShown = true;

        function toggleEmailPhone(el){
            if(isPhoneShown){
                $('.phone-form-group').addClass('d-none');
                $('.email-form-group').removeClass('d-none');
                isPhoneShown = false;
                $(el).html('{{ translate('Use Phone Instead') }}');
            }
            else{
                $('.phone-form-group').removeClass('d-none');
                $('.email-form-group').addClass('d-none');
                isPhoneShown = true;
                $(el).html('{{ translate('Use Email Instead') }}');
            }
        }
    </script>
@endsection
