@extends('frontend.layouts.app')

@section('content')

<div class="all-category-wrap py-4 gry-bg">
    <div class="sticky-top">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="bg-white all-category-menu">
                        <ul class="d-flex flex-wrap no-scrollbar">
                            @if(count($categories) > 12)
                                @for ($i = 0; $i < 11; $i++)
                                    <li class="@php if($i == 0) echo 'active' @endphp">
                                        <a href="#{{ $i }}" class="row no-gutters align-items-center">
                                            <div class="col-md-3">
                                                <img src="{{ $categories[0]->icon }}" alt="">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="cat-name">{{ $categories[$i]->name }}</div>
                                            </div>
                                        </a>
                                    </li>
                                @endfor
                                <li class="">
                                    <a href="#more" class="row no-gutters align-items-center">
                                        <div class="col-md-3">
                                            <i class="fa fa-ellipsis-h cat-icon"></i>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="cat-name">{{ translate('More Categories')}}</div>
                                        </div>
                                    </a>
                                </li>
                            @else
                                @foreach ($categories as $key => $category)
                                    <li class="@php if($key == 0) echo 'active' @endphp">
                                        <a href="#{{ $key }}" class="row no-gutters align-items-center">
                                            <div class="col-md-3">
                                                <img loading="lazy"  class="cat-image" src="{{ uploaded_asset($category->icon) }}">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="cat-name">{{  __($category->name) }}</div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="container">
            @foreach ($categories as $key => $category)
                @if(count($categories)>12 && $key == 11)
                <div class="mb-3 bg-white">
                    <div class="sub-category-menu active" id="more">
                        <h3 class="category-name border-bottom pb-2">
                            <a href="{{ route('products.category', $category->slug) }}">{{  __($category->name) }}</a>
                        </h3>
                        <div class="row">
                            @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category->id) as $key => $first_level_id)
                                <div class="col-lg-3 col-6 text-left">
                                    <h6 class="mb-3">
                                        <a href="{{ route('products.category', \App\Category::find($first_level_id)->slug) }}" class="d-block rounded bg-white p-2 text-reset shadow-sm">
                                            <img src="{{ uploaded_asset(\App\Category::find($first_level_id)->banner) }}" data-src="{{ uploaded_asset(\App\Category::find($first_level_id)->banner) }}" alt="{{ \App\Category::find($first_level_id)->getTranslation('name') }}" class="ls-is-cached lazyloaded" height="78" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </a>
                                        <a class="text-reset fw-600 fs-14" href="{{ route('products.category', \App\Category::find($first_level_id)->slug) }}">{{ \App\Category::find($first_level_id)->getTranslation('name') }}</a>
                                    </h6>
                                    <ul class="mb-3 list-unstyled pl-2">
                                        @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($first_level_id) as $key => $second_level_id)
                                            <li class="mb-2">
                                                <a class="text-reset" href="{{ route('products.category', \App\Category::find($second_level_id)->slug) }}" >{{ \App\Category::find($second_level_id)->getTranslation('name') }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <div class="mb-3 bg-white">
                    <div class="sub-category-menu @php if($key < 12) echo 'active'; @endphp" id="{{ $key }}">
                        <h3 class="category-name border-bottom pb-2"><a href="{{ route('products.category', $category->slug) }}" >{{  __($category->name) }}</a></h3>
                        <div class="row">

                            @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category->id) as $key => $first_level_id)
                                <div class="col-lg-3 col-6 text-left">
                                    <h6 class="mb-3">
                                        <a href="{{ route('products.category', \App\Category::find($first_level_id)->slug) }}" class="d-block rounded bg-white p-2 text-reset shadow-sm">
                                            <img src="{{ uploaded_asset(\App\Category::find($first_level_id)->banner) }}" data-src="{{ uploaded_asset(\App\Category::find($first_level_id)->banner) }}" alt="{{ \App\Category::find($first_level_id)->getTranslation('name') }}" class="ls-is-cached lazyloaded" height="78" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </a>
                                        <a class="text-reset fw-600 fs-14" href="{{ route('products.category', \App\Category::find($first_level_id)->slug) }}">{{ \App\Category::find($first_level_id)->getTranslation('name') }}</a>
                                    </h6>
                                    <ul class="mb-3 list-unstyled pl-2">
                                        @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($first_level_id) as $key => $second_level_id)
                                            <li class="mb-2">
                                                <a class="text-reset" href="{{ route('products.category', \App\Category::find($second_level_id)->slug) }}" >{{ \App\Category::find($second_level_id)->getTranslation('name') }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

@endsection
