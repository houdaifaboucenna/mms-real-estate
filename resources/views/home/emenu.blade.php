@extends('layouts.app')

@section('pageTitle', __('home.properties'))

@section('content')
    <div class="container" id="estates-menu">
        <div class="row justify-content-center">
            <div class="col-md p-0">

                {{-- Banner --}}
                <div class="banner">
                    <img src="{{ asset('images/background/background-5.jpg') }}" alt="" class="back">
                    <div class="overlay"></div>
                    <h1>
                        @isset($title)
                            {{ $title }}
                        @else
                            {{ __('home.properties') }}
                        @endisset
                    </h1>
                </div>

                @if (!isset($nosearch))
                    {{-- Search filter inline --}}
                    <div id="filters">
                        <form action="{{ route('app.estate_filter') }}" method="get">
                            @csrf
                            <div class="row">
                                {{-- City --}}
                                <div class="col-md">
                                    <div class="form-group">
                                        <select class="form-control selectpicker" name="city" id="city">
                                            <option value="city">{{ __('home.ch_city') }}</option>
                                            @foreach ($cities as $i => $city)
                                                <option value="{{ $i }}">{{ $city }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Town --}}
                                <div class="col-md">
                                    <div class="form-group">
                                        <select id="town" class="form-control selectpicker" name="town">
                                            <option value="town">{{ __('home.ch_town') }}</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- Type --}}
                                <div class="col-md">
                                    <div class="form-group">
                                        <select id="type" class="form-control selectpicker" name="type">
                                            <option value="type">{{ __('home.ch_type') }}</option>
                                            @foreach ($types as $i => $type)
                                                <option value="{{ $i }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Price --}}
                                <div class="col-md-3">
                                    <div class="form-group text-center price-form">
                                        <input type="text" class="js-range-slider" name="price_range" value=""
                                            id="price_range" data-type="double" data-min="0"
                                            data-max="{{ $maxPrice + 0.1 * $maxPrice }}" data-from="{{ $minPrice }}"
                                            data-to="{{ $maxPrice }}" />
                                        <input type="hidden" name="from" id="from" value="">
                                        <input type="hidden" name="to" id="to" value="">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <button type="submit" class="btn btn-primary pop">{{ __('home.search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endisset

                {{-- estates list --}}
                <div class="row" id="estates">

                    @if ($estates->count() == 0)
                        <h5>{{ __('home.nofound') }}</h5>
                    @endif

                    @foreach ($estates as $estate)
                        {{-- estate Item --}}
                        <div class="col-md-4 mb-2">
                            <div class="estate">
                                <div class="estate-img">
                                    @foreach (json_decode($estate->image) as $key => $img)
                                        @if ($key == 0)
                                            <img src="{{ asset('/storage/' . $img) }}" alt=""
                                                class="d-block w-100">
                                        @endif
                                    @endforeach
                                </div>
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
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="row">
                    <div class="col-md-2">
                        {{ $estates->links() }}
                    </div>
                </div>

        </div>
    </div>
</div>
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
        skin: "square",
        hide_min_max: true,
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
</script>
@endsection
