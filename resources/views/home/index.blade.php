@extends('layouts.app')

@section('pageTitle', __('home.home'))

@section('content')
    <section id="homepage">

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

        {{-- Home --}}
        <div class="row" id="home">

            {{-- Filters --}}
            <div class="col-md-3">
                <div id="filters">
                    <h3>{{ __('home.filters_title') }}</h3>
                    <form action="{{ route('app.estate_filter') }}" method="get">
                        @csrf
                        {{-- From --}}
                        <div class="form-group">
                            <select class="form-control selectpicker" name="city" id="city">
                                <option value="city">{{ __('home.ch_city') }}</option>
                                @foreach ($cities as $i => $city)
                                    <option value="{{ $i }}">{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Town --}}
                        <div class="form-group">
                            <select id="town" class="form-control selectpicker" name="town">
                                <option value="town">{{ __('home.ch_town') }}</option>
                            </select>
                        </div>
                        {{-- Type --}}
                        <div class="form-group">
                            <select id="type" class="form-control selectpicker" name="type">
                                <option value="type">{{ __('home.ch_type') }}</option>
                                @foreach ($types as $i => $type)
                                    <option value="{{ $i }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Price --}}
                        <div class="form-group text-center">
                            <label for="">{{ __('home.price') }}</label>
                            <input type="text" class="js-range-slider" name="price_range" value="" id="price_range"
                                data-type="double" data-min="0" data-max="{{ $maxPrice + 0.1 * $maxPrice }}"
                                data-from="{{ $minPrice }}" data-to="{{ $maxPrice }}" />
                            <input type="hidden" name="from" id="from" value="">
                            <input type="hidden" name="to" id="to" value="">
                        </div>
                        <button type="submit" class="btn btn-primary pop">{{ __('home.search') }}</button>
                    </form>
                </div>
            </div>

            {{-- Carousel --}}
            <div class="col-md-9">

                <div id="home-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @if (setting('home_imgs'))
                            @foreach (json_decode(setting('home_imgs')) as $i => $img)
                                <div class="carousel-item @if ($i == 0) active @endif">
                                    <img class="d-block w-100" src="{{ asset('/storage/' . $img) }}" alt="">
                                </div>
                            @endforeach
                        @else
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="https://place-hold.it/870x380" alt="">
                            </div>
                        @endif
                    </div>
                    <a class="carousel-control-prev" href="#home-carousel" data-slide="prev" role="button">
                        <div class="arr-c">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#home-carousel" data-slide="next" role="button">
                        <div class="arr-c">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </div>
                    </a>
                </div>

                <div class="row" id="box-row">
                    <div class="col-md-4">
                        <div class="box">
                            <p>{{ __('home.blog_text') }}</p>
                            <a href="{{ route('app.posts') }}" class="btn pop">{{ __('home.blog') }}</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <p>{{ __('home.about_text') }}</p>
                            <a href="{{ route('app.about') }}" class="btn pop">{{ __('home.about') }}</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <p>{{ __('home.contact_text') }}</p>
                            <a href="{{ route('app.contact') }}" class="btn pop">{{ __('home.contactus') }}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Featured --}}
        <div class="row" id="estates-row">
            <div class="col-md">
                <div class="c-col">
                    <div class="row">
                        <div class="col-md-12 position-relative">
                            <h2>{{ __('home.featured') }}</h2>
                            <p>{{ __('home.featured_text') }}</p>
                            <a href="{{ route('app.estates') }}" class="all">{{ __('home.all_estates') }}
                                <span>({{ $e_count }})</span></a>
                        </div>
                        @foreach ($estates as $estate)
                            <div class="col-md-4 mb-2">
                                <div class="estate">
                                    {{-- @foreach (json_decode($estate->image) as $key => $img)
                                        @if ($key == 0)
                                            <img src="{{ asset('/storage/' . $img) }}" alt=""
                                                class="d-block w-100">
                                        @endif
                                    @endforeach --}}
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
                                                href="{{ route('app.estate_city', $estate->city->id) }}"><span>{{ $estate->city->name }}</span></a>,
                                            <a
                                                href="{{ route('app.estate_town', [$estate->city->name, $estate->town_id]) }}"><span>{{ $estate->town->name }}</span></a>
                                        </div>
                                        <p class="short">
                                            @if (isLang('en'))
                                                {{ $estate->short }}
                                            @else
                                                {{ $estate->short_ar }}
                                            @endif
                                        </p>
                                        <p class="price">
                                            <span class="min">{{ $estate->min }}</span><span
                                                class="currency">$</span>
                                            <span> - </span>
                                            <span>{{ $estate->max }}</span><span class="currency">$</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Blog --}}
        <div class="row" id="blog-row">
            <div class="col-md">
                <div class="c-col">
                    <div class="row">
                        <div class="col-md-12 position-relative">
                            <h2>{{ __('home.our_blog') }}</h2>
                            <p>{{ __('home.blog_text') }}</p>
                            <a href="{{ route('app.posts') }}" class="all">{{ __('home.all_articles') }}
                                <span>({{ $p_count }})</span></a>
                        </div>
                        @foreach ($posts as $post)
                            <div class="col-md-3 mb-2">
                                <div class="article">
                                    <img src="{{ asset('/storage/' . $post->image) }}" alt=""
                                        class="d-block w-100">
                                    <span class="ar">{{ __('home.article') }}</span>
                                    <div>
                                        <p class="title">
                                            @if (isLang('en'))
                                                {{ $post->title }}
                                            @else
                                                {{ $post->title_ar }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="mt-2"><a href="{{ route('app.post', $post->slug) }}"><span
                                                class="rdm">{{ __('home.readmore') }}</span></a></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- FAQ --}}
        <div class="row" id="faq-row">
            <div class="col-md">
                <div class="c-col">
                    <div class="row">
                        <div class="col-md-12 position-relative">
                            <h2>{{ __('home.faq') }}</h2>
                            <a href="{{ route('app.faq') }}" class="all">{{ __('home.all_faq') }}
                                <span>({{ $f_count }})</span></a>
                        </div>

                        <div class="col-md-8">
                            <div id="faqAcc" role="tablist" aria-multiselectable="true" class="mt-2">
                                @foreach ($faqs as $key => $faq)
                                    <div class="card">
                                        <div class="card-header" role="tab">
                                            <h5 class="mb-0">
                                                <a data-toggle="collapse" data-parent="#faqAcc"
                                                    href="#faq-{{ $key + 1 }}" aria-expanded="false"
                                                    aria-controls="faq-{{ $key + 1 }}" class="collapsed">
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

                        <div class="col-md-4">

                            {{-- Contact Form --}}
                            <form action="{{ route('contacts.store') }}" id="c-form" method="POST"
                                class="text-center">
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
                                    <textarea id="message" class="form-control" name="message" rows="4"
                                        placeholder="{{ __('home.message') }}"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('home.contactus') }}</button>

                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div id="pop_up">
            <button class="btn d-none pop_btn" type="button" data-toggle="modal"
                data-target="#pop-form">Content</button>
            <div id="pop-form" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content border-0">
                        <div class="modal-body p-0">
                            <button class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{-- Contact Form --}}
                            <form action="{{ route('contacts.store') }}" id="c-form" method="POST"
                                class="text-center mt-0">
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
                                    <textarea id="message" class="form-control" name="message" rows="4"
                                        placeholder="{{ __('home.message') }}"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('home.contactus') }}</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
    <script>
        /* Towns Data */
        $("#city").change(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var towns = $("#town")
            var ul = towns.siblings(".dropdown-menu").children(".inner").children('ul');
            var city = $("#city option:eq(" + ($(this).val()) + ")").text();
            $.ajax({
                type: "POST",
                url: "/towns",
                data: {
                    _token: CSRF_TOKEN,
                    city: city
                },
                dataType: "json",
                success: function(response) {
                    var options = "<option value='0'>{{ __('home.ch_town') }}</option>"
                    for (let i = 0; i < response.towns.length; i++) {
                        options += "<option value='" + (i + 1) + "'>" + response.towns[i] + "</option>"
                    }
                    towns.html(options)
                    $("#town").selectpicker('refresh')
                }
            });

        });

        /* Ion Range Slider */
        var $range = $("#price_range");
        var $inputFrom = $("#from");
        var $inputTo = $("#to");
        $range.ionRangeSlider({
            onStart: updateInputs,
            onChange: updateInputs,
            onFinish: updateInputs
        });
        instance = $range.data("ionRangeSlider");

        function updateInputs(data) {
            from = data.from;
            to = data.to;
            $inputFrom.prop("value", from);
            $inputTo.prop("value", to);
        }

        setTimeout(function() {
            $(".pop_btn").trigger('click');
        }, 10000);
    </script>
@endsection
