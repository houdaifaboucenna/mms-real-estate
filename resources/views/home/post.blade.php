@extends('layouts.app')

@section('pageTitle', $post->title)

@section('content')
    <div class="container" id="post_p">
        <div class="row justify-content-center">
            <div class="col-md-8 p-0">

                {{-- Show success message --}}
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Post Info --}}
                <div id="post">
                    <div class="post-img">
                        <img src="{{ '/storage/' . $post->image }}" alt="">
                    </div>
                    <h1 class="post-title">
                        @if (isLang('en'))
                            {{ $post->title }}
                        @else
                            {{ $post->title_ar }}
                        @endif
                    </h1>
                    <div class="post-content">
                        @if (isLang('en'))
                            {!! $post->content !!}
                        @else
                            {!! $post->content_ar !!}
                        @endif
                    </div>
                </div>

                {{-- Show comments --}}
                <div class="post-comments">

                    @foreach ($post->comments as $comment)
                        <div class="c-item">
                            <div class="c-info">
                                <p><img src="{{ getGravatar($comment->email) }}" alt=""></p>
                                <p class="c-name">{{ $comment->name }}</p>
                            </div>
                            <div class="c-content">
                                {{ $comment->content }}
                            </div>
                        </div>
                    @endforeach

                </div>

                {{-- Add comment --}}
                <form action="{{ route('comments.store') }}" id="comment" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="name" class="form-control" type="text" name="name"
                                    placeholder="{{ __('home.name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="email" class="form-control" type="email" name="email"
                                    placeholder="{{ __('home.email') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <textarea id="c-content" class="form-control" name="content" rows="3"
                                    placeholder="{{ __('home.add_comment') }} ..."></textarea>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                    <button type="submit" class="btn btn-primary">{{ __('home.add_comment') }}</button>

                </form>

            </div>

            <div class="col-md-4">

                {{-- Contact Form --}}
                <form action="{{ route('contacts.store') }}" id="c-form" method="POST" class="text-center">
                    @csrf
                    <h3>{{ __('home.getin') }}</h3>
                    <p>{{ __('home.fillin') }}</p>

                    <div class="form-group">
                        <input id="name" class="form-control" type="text" name="name"
                            placeholder="{{ __('home.name') }}">
                    </div>

                    <div class="form-group">
                        <input id="email" class="form-control" type="email" name="email"
                            placeholder="{{ __('home.email') }}">
                    </div>

                    <div class="form-group">
                        <input id="tel" class="form-control" type="tel" name="phone"
                            placeholder="{{ __('home.phone') }}">
                    </div>

                    <div class="form-group">
                        <textarea id="message" class="form-control" name="message" rows="4" placeholder="{{ __('home.message') }}"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('home.contactus') }}</button>

                </form>

            </div>
        </div>
    </div>
@endsection
