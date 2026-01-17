@extends('layouts.app')

@section('pageTitle', $estate->title)

@section('content')
    <div class="container" id="estate_p">
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

                {{-- Estate Info --}}
                <div id="estate">
                    <h1 class="estate-title">
                        @if (isLang('en'))
                            {{ $estate->title }}
                        @else
                            {{ $estate->title_ar }}
                        @endif
                    </h1>
                    <p class="estate-short">
                        @if (isLang('en'))
                            {{ $estate->short }}
                        @else
                            {{ $estate->short_ar }}
                        @endif
                    </p>
                    <div class="proj-show position-relative">
                        <div class="estate-img owl-carousel owl-theme proj-show-carousel">
                            @foreach (json_decode($estate->image) as $img)
                                <div class="item"><img class="lazyload blur-up" src="{{ '/storage/' . $img }}"
                                        alt=""></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="proj-thumbs position-relative">
                        <div class="owl-carousel owl-theme proj-thumbs-carousel nav-on-side">
                            @foreach (json_decode($estate->image) as $img)
                                <div class="item"><img class="owl-lazy" src="{{ '/storage/' . $img }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="estate-info">
                        <div class="e-box">
                            <span class="iconify" data-icon="healthicons:city-outline" data-width="48"
                                data-height="48"></span>
                            <span class="lb">{{ __('home.city') }}</span>
                            <span>{{ $estate->getCity() }}</span>
                        </div>
                        <div class="e-box">
                            <span class="iconify" data-icon="maki:town-hall" data-width="48" data-height="48"></span>
                            <span class="lb">{{ __('home.town') }}</span>
                            <span>{{ $estate->getTown() }}</span>
                        </div>
                        <div class="e-box">
                            <span class="iconify" data-icon="mdi:home-city-outline" data-width="48" data-height="48"></span>
                            <span class="lb">{{ __('home.type') }}</span>
                            <span>{{ $estate->getType() }}</span>
                        </div>
                        <div class="e-box">
                            <span class="iconify" data-icon="dashicons:money-alt" data-width="48" data-height="48"></span>
                            <span class="lb">{{ __('home.price') }}</span>
                            <div>
                                <span class="min">{{ $estate->min }}</span><span class="currency"> $ </span>-
                                <span class="max">{{ $estate->max }}</span><span class="currency"> $ </span>
                            </div>
                        </div>
                    </div>
                    <div class="estate-content">
                        @if (isLang('en'))
                            {!! $estate->content !!}
                        @else
                            {!! $estate->content_ar !!}
                        @endif
                    </div>
                </div>

                {{-- Other Project --}}
                <div class="row" id="similar">
                    <div class="col-md-12">
                        <h3>{{ __('home.similar') }}</h3>
                    </div>
                    <div class="col-md-6">
                        @foreach ($others as $estate)
                            <div class="sim">
                                @foreach (json_decode($estate->image) as $key => $img)
                                    @if ($key == 0)
                                        <img src="{{ asset('/storage/' . $img) }}" alt="" class="d-block w-100">
                                    @endif
                                @endforeach
                                <span class="ar">{{ $estate->getType() }}</span>
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
                                            href="{{ route('app.estate_city', $estate->city) }}"><span>{{ $estate->getCity() }}</span></a>,
                                        <a
                                            href="{{ route('app.estate_town', [$estate->getCity(), $estate->town - 1]) }}"><span>{{ $estate->getTown() }}</span></a>
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
                        @endforeach
                    </div>
                </div>

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

@section('scripts')
    <script>
        $(document).ready(function() {
            var rtl = false
            @if (Session::get('lang') == 'ar')
                rtl = true
            @endif

            // Projects Show Carousel
            $('.proj-show-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                rtl: rtl,
                navText: ['<span class="iconify" data-icon="akar-icons:chevron-left"></span>',
                    '<span class="iconify" data-icon="akar-icons:chevron-right"></span>'
                ],
                navClass: ['owl-prev', 'owl-next'],
                dots: false,
                dotsContainer: '.interior',
                rewind: true,
                center: true,
                items: 1,
            }).on("changed.owl.carousel", function(e) {
                $(".proj-thumbs-carousel").trigger("to.owl.carousel", [e.item.index - 2, 200, !0]);
            });

            // Projects Thumbs Carousel
            $('.proj-thumbs-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                dots: false,
                rtl: rtl,
                lazyLoad: true,
                center: true,
                rewind: true,
                autoWidth: true,
                navText: ['<span class="iconify" data-icon="akar-icons:chevron-left"></span>',
                    '<span class="iconify" data-icon="akar-icons:chevron-right"></span>'
                ],
                navClass: ['owl-prev', 'owl-next'],
                items: 1,
            }).on("click", ".owl-item .item", function() {
                var x = $(this).parent().index();
                $(".proj-show-carousel").trigger("to.owl.carousel", [x - 2, 200, !0])
                $(this).parent().addClass('center').siblings().removeClass('center')
            });
        });
    </script>
@endsection
