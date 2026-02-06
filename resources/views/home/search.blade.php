@extends('layouts.app')

@section('pageTitle', __('home.blog'))

@section('content')
    <div class="container" id="search-menu">
        <div class="row justify-content-center">
            <div class="col-md p-0">

                {{-- Banner --}}
                <div class="banner">
                    <img src="{{ asset('images/background/background-1.jpg') }}" alt="" class="back">
                    <div class="overlay"></div>
                    <h1>{{ __('home.search_res') }}</h1>
                </div>

                {{-- estates list --}}
                <div class="row search-cat">

                    <div class="col-md-12">
                        <h3>{{ __('home.estates') }}({{ $estates->count() }})</h3>
                    </div>

                    @foreach ($estates as $estate)
                        {{-- estate Item --}}
                        <div class="col-md-4 mb-4">
                            <div class="estate">
                                <div class="estate-img">
                                    @foreach (json_decode($estate->image) as $key => $img)
                                        @if ($key == 0)
                                            <img src="{{ asset('/storage/' . $img) }}" alt="" class="d-block w-100">
                                        @endif
                                    @endforeach
                                </div>
                                <span class="ar">{{ $estate->type }}</span>
                                <div class="details">
                                    <a href="{{ route('app.estate', $estate->slug) }}">
                                        <h4 class="title">
                                            @if (isLang('en'))
                                                {{ $estate->title }}
                                            @else
                                                {{ $estate->title_ar }}
                                            @endif
                                        </h4>
                                    </a>
                                    <div class="location">
                                        <span class="iconify" data-icon="carbon:location-filled"></span>
                                        <a
                                            href="{{ route('app.estate_city', $estate->city) }}"><span>{{ $estate->city->name }}</span></a>,
                                        <a
                                            href="{{ route('app.estate_town', [$estate->city->name, $estate->town]) }}"><span>{{ $estate->town->name }}</span></a>
                                    </div>
                                    <p class="short">
                                        @if (isLang('en'))
                                            {{ $estate->short }}
                                        @else
                                            {{ $estate->short_ar }}
                                        @endif
                                    </p>
                                    <p class="price">
                                        <span class="min">{{ $estate->min }}</span><span class="currency">$</span>
                                        <span> - </span>
                                        <span>{{ $estate->max }}</span><span class="currency">$</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Posts list --}}
                <div class="row search-cat">
                    <div class="col-md-12">
                        <h3>{{ __('home.articles') }}({{ $posts->count() }})</h3>
                    </div>
                    @foreach ($posts as $post)
                        {{-- Post Item --}}
                        <div class="col-md-4">
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

                {{-- FAQ --}}
                <div class="row search-cat" id="faq-row">
                    <div class="col-md-12">
                        <h3>{{ __('home.faq') }}({{ $faqs->count() }})</h3>
                    </div>
                    <div class="col-md-12">
                        <div id="faqAcc" role="tablist" aria-multiselectable="true" class="mt-2">
                            @foreach ($faqs as $key => $faq)
                                <div class="card">
                                    <div class="card-header" role="tab">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" data-parent="#faqAcc" href="#faq-{{ $key + 1 }}"
                                                aria-expanded="false" aria-controls="faq-{{ $key + 1 }}"
                                                class="collapsed">
                                                <span class="iconify" data-icon="bi:bookmark-plus"></span>
                                                @if (isLang('en'))
                                                    {{ $faq->question }}
                                                @else
                                                    {{ $faq->question_ar }}
                                                @endif
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="faq-{{ $key + 1 }}" class="collapse in" role="tabpanel">
                                        <div class="card-body">
                                            @if (isLang('en'))
                                                {!! $faq->answer !!}
                                            @else
                                                {!! $faq->answer_ar !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
