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
                                    {{ translate('Verify your OTP code.')}}
                                </h1>
                            </div>

                            <div class="px-4 py-3 py-lg-4">
                                <div class="">
                                    <form class="form-default" role="form" action="{{ route('user.login.verify') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}" placeholder="{{ translate('Code')}}" name="code" id="code">
                                        </div>

                                        <div class="mb-2">
                                            <button type="submit" class="btn btn-primary bg-matt btn-block fw-600">{{  translate('Verify') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="text-center">
                                    <p class="text-muted mb-0 fs-14">{{ translate('Dont got OTP code?')}}</p>
                                    <a class="fs-16" href="#">{{ translate('Resend Code')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

