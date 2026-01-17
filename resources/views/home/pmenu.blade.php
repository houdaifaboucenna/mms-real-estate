@extends('layouts.app')

@section('pageTitle', __('home.blog'))

@section('content')
  <div class="container" id="posts-menu">
    <div class="row justify-content-center">
      <div class="col-md p-0">

        {{-- Banner --}}
        <div class="banner">
          <img src="{{ asset('images/background/background-2.jpg') }}" alt="" class="back">
          <div class="overlay"></div>
          <h1>{{ __('home.all_articles') }}</h1>
        </div>

        {{-- Posts list --}}
        <div class="row" id="posts">
          @foreach ($posts as $post)
            {{-- Post Item --}}
            <div class="col-md-4 mb-2">
              <div class="post">
                <div class="post-img">
                  <img src="{{ '/storage/' . $post->image }}" alt="">
                </div>
                <a href="{{ route('app.post', $post->slug) }}" class="post-title">
                  @if (isLang('en'))
                    {{ $post->title }}
                  @else
                    {{ $post->title_ar }}
                  @endif
                </a>
                <div class="post-date">{{ $post->created_at->format('Y-m-d') }}</div>
              </div>
            </div>
          @endforeach
        </div>

        {{-- Pagination --}}
        <div class="row">
          <div class="col-md">
            {{ $posts->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection