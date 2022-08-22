<!DOCTYPE html>
@if(\App\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
<html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@else
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endif
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta name="file-base-url" content="{{ getFileBaseURL() }}">

    <title>@yield('meta_title', get_setting('website_name').' | '.get_setting('site_motto'))</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="description" content="@yield('meta_description', get_setting('meta_description') )" />
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords') )">

    <!-- CSS Files -->

    <link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
    <link rel="stylesheet" href="{{ static_asset('assets/css/aiz-core.css') }}">

    <script>
        var AIZ = AIZ || {};
        AIZ.local = {
            nothing_found: '{{ translate('Nothing Found') }}'
        }
    </script>
</head>
<body>

    @yield('content')

    @yield("modal")
    <!-- SCRIPTS -->
    <script src="{{ static_asset('assets/js/vendors.js') }}"></script>
    <script src="{{ static_asset('assets/js/aiz-core.js') }}"></script>

    @yield('script')
    <script>
         function imageInputInitialize(){
             $('.custom-input-file').each(function() {
                 var $input = $(this),
                     $label = $input.next('label'),
                     labelVal = $label.html();

                 $input.on('change', function(e) {
                     var fileName = '';

                     if (this.files && this.files.length > 1)
                         fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
                     else if (e.target.value)
                         fileName = e.target.value.split('\\').pop();

                     if (fileName)
                         $label.find('span').html(fileName);
                     else
                         $label.html(labelVal);
                 });

                 // Firefox bug fix
                 $input
                     .on('focus', function() {
                         $input.addClass('has-focus');
                     })
                     .on('blur', function() {
                         $input.removeClass('has-focus');
                     });
             });
         }
    </script>
</body>
</html>
