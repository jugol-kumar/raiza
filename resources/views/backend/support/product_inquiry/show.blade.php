@extends('backend.layouts.app')

@section('content')

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title"># {{ $conversations->name }}
            </h5>
        </div>

    
        <div class="card-body">
            <div class="media mb-2">
              <img class="avatar avatar-xs mr-3" 
              @if($conversations->user != null) src="{{ uploaded_asset($conversations->user->avatar_original) }}" @endif onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
              <div class="media-body">
                <h6 class="mb-0 fw-600">
                    @if ($conversations->user != null)
                        {{ $conversations->user->name }}
                    @endif
                </h6>
                <p class="opacity-50">{{$conversations->created_at}}</p>
              </div>
            </div>
            <p>
                {{ $conversations->message }}
            </p>
            
            <div class="card">
                <div class="card-body">
                    <h3>{{ $conversations->product->name }}</h3>
                        <img class="thamblen mr-3" 
                             @if($conversations->user != null) 
                                src="{{ uploaded_asset($conversations->product->thumbnail_img) }}" 
                             @endif 
                             onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                   

            <br>
            <p>
                {!! $conversations->product->description !!}
            </p>

                </div>
            </div>
            
            
            
        </div>
    </div>
</div>

@endsection
