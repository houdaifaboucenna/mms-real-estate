<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('pageTitle') | MmsEstate</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo1.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!--Plugin CSS file with desired skin-->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css" />

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <!-- Owl carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- InputTel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    {{-- Assets JS/CSS --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Styles -->
    @if (Session::get('lang') == 'ar')
        @vite(['resources/sass/app_ar.scss'])
    @endif

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

</head>

<body id="home">
    <div id="app">
        <header>
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo1.png') }}" alt="" class="nav-logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="d-sm-none d-block lang-m">
                    <a class="lang" href="{{ route('app.switch_lang') }}">
                        <span>{{ isLang('en') ? 'Ar' : 'En' }}</span>
                    </a>
                </div>


                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Navbar content -->
                    <ul class="navbar-nav">
                        <div class="upper-nav">
                            <form class="form-inline search-top" action="{{ route('app.search') }}" method="GET">
                                @csrf
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="iconify" data-icon="ci:search" data-height="20"
                                                data-width="20"></span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="{{ __('home.search') }}"
                                        name="q" aria-describedby="basic-addon1">
                                </div>
                            </form>
                            <div class="n-tel">
                                <a href="tel:{{ setting('phone') }}">
                                    <span class="iconify" data-icon="bi:telephone-fill"></span>
                                    <span class="num">{{ setting('phone') }}</span>
                                </a>
                            </div>
                            <div class="n-whatsapp">
                                <a href="https://wa.me/{{ str_replace(' ', '', setting('whatsapp')) }}"
                                    target="_blank">
                                    <span class="iconify" data-icon="bi:whatsapp"></span>
                                    <span class="num">{{ setting('whatsapp') }}</span>
                                </a>
                            </div>
                            <div class="n-social">
                                <a href="{{ setting('facebook') }}"><span class="iconify"
                                        data-icon="cib:facebook"></span></a>
                                <a href="{{ setting('instagram') }}"><span class="iconify"
                                        data-icon="cib:instagram"></span></a>
                                <a href="{{ setting('twitter') }}"><span class="iconify"
                                        data-icon="cib:twitter"></span></a>
                                <a href="{{ setting('telegram') }}"><span class="iconify"
                                        data-icon="cib:telegram"></span></a>
                                <a href="{{ setting('linkedin') }}"><span class="iconify"
                                        data-icon="cib:linkedin"></span></a>
                            </div>
                        </div>

                        <div class="lower-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('app.home') }}">{{ __('home.home') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ route('app.estates') }}">{{ __('home.properties') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('app.posts') }}">{{ __('home.blog') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('app.about') }}">{{ __('home.about') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('app.contact') }}">{{ __('home.contactus') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('app.faq') }}">{{ __('home.Faq') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link lang d-sm-block d-none" href="{{ route('app.switch_lang') }}">
                                    @if (isLang('en'))
                                        <span>Ar</span>
                                    @else
                                        <span>En</span>
                                    @endif
                                </a>
                            </li>
                        </div>
                    </ul>
                </div>
            </nav>
        </header>

        <main class="container-fluid py-4">
            @yield('content')
        </main>

        <footer class="container-fluid py-4">
            <div class="row p-4">
                <div class="col-md-3" id="fs-logo">
                    <a href="{{ route('app.home') }}"><img src="{{ asset('images/logo1.png') }}" alt=""
                            class="logo-f"></a>
                </div>
                <div class="col-md-3">
                    <h3>{{ __('home.lts_articles') }}</h3>
                    <ul>
                        @foreach (App\Models\Post::latest()->limit(3)->get() as $post)
                            <a href="{{ route('app.post', $post->slug) }}">
                                <li>
                                    @if (isLang('en'))
                                        {{ $post->title }}
                                    @else
                                        {{ $post->title_ar }}
                                    @endif
                                </li>
                            </a>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-3">
                    <h3>{{ __('home.prp_types') }}</h3>
                    <ul>
                        @foreach (App\Models\Estate::types() as $i => $type)
                            <a href="{{ route('app.estate_type', $i) }}">
                                <li>{{ $type }}
                                    <span>({{ App\Models\Estate::where('type', $i)->count() }})</span>
                                </li>
                            </a>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-3" id="fs-contact">
                    <h3>{{ __('home.stay_connect') }}</h3>
                    <ul class="n-social mt-3 mb-1">
                        <li class="pop">
                            <a href="{{ setting('facebook') }}"><span class="iconify"
                                    data-icon="cib:facebook"></span></a>
                        </li>
                        <li class="pop">
                            <a href="{{ setting('instagram') }}"><span class="iconify"
                                    data-icon="cib:instagram"></span></a>
                        </li>
                        <li class="pop">
                            <a href="{{ setting('twitter') }}"><span class="iconify"
                                    data-icon="cib:twitter"></span></a>
                        </li>
                        <li class="pop">
                            <a href="{{ setting('telegram') }}"><span class="iconify"
                                    data-icon="cib:telegram"></span></a>
                        </li>
                        <li class="pop">
                            <a href="{{ setting('linkedin') }}"><span class="iconify"
                                    data-icon="cib:linkedin"></span></a>
                        </li>
                    </ul>
                    <h3 class="mt-4">{{ __('home.contactus') }}</h3>
                    <ul>
                        <li class="n-tel">
                            <a href="tel:{{ setting('phone') }}">
                                <span class="iconify" data-icon="bi:telephone-fill"></span>
                                <span class="num">{{ setting('phone') }}</span>
                            </a>
                        </li>
                        <li class="n-whatsapp">
                            <a href="https://wa.me/{{ str_replace(' ', '', setting('whatsapp')) }}" target="_blank">
                                <span class="iconify" data-icon="bi:whatsapp"></span>
                                <span class="num">{{ setting('whatsapp') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row" id="copyright">
                <div class="col-md-12 text-center">
                    <div class="copy">
                        {{ __('home.copyright') }}
                    </div>
                </div>
            </div>
        </footer>

        {{-- Scroll Top --}}
        <button onclick="topFunction()" id="scrTop"><span class="iconify" data-icon="cil:arrow-top"
                data-width="24" data-height="24"></span>
        </button>

    </div>

    {{-- Scripts --}}
    <script src="https://code.iconify.design/2/2.1.0/iconify.min.js"></script>
    <script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>


    <!--jQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!--Plugin JavaScript file-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"
        integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- Owl Carousel --}}
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- IntlTelInput --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    {{-- CKEditor Media --}}
    <script>
        document.querySelectorAll('oembed[url]').forEach(element => {
            const anchor = document.createElement('a');
            anchor.setAttribute('href', element.getAttribute('url'));
            anchor.className = 'embedly-card';
            element.appendChild(anchor);
        });
    </script>

    <!-- GetButton.io widget -->
    <script type="text/javascript">
        (function() {
            var options = {
                whatsapp: "{{ setting('whatsapp') }}",
                call_to_action: "{{ __('home.contactus') }}",
                position: "right",
            };
            var proto = document.location.protocol,
                host = "getbutton.io",
                url = proto + "//static." + host;
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = url + '/widget-send-button/js/init.js';
            s.onload = function() {
                WhWidgetSendButton.init(host, proto, options);
            };
            var x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
        })();
    </script>

    {{-- Scroll Top --}}
    <script>
        mybutton = document.getElementById("scrTop");
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) mybutton.style.display = "block";
            else mybutton.style.display = "none";
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>

    {{-- Initialize SelectPicker --}}
    <script>
        $(document).ready(function() {
            $('select').selectpicker();
        })
    </script>

    <script>
        function getIp(callback) {
            fetch('https://ipinfo.io/json?token=7221af36e45b9a', {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then((resp) => resp.json())
                .catch(() => {
                    return {
                        country: 'tr',
                    };
                })
                .then((resp) => callback(resp.country));
        }

        const phoneInputField = document.querySelector("#tel");
        const phoneInput = window.intlTelInput(phoneInputField, {
            initialCountry: "auto",
            geoIpLookup: getIp,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    </script>

    <script>
        // $(".navbar-toggler[aria-expanded='false']").on('click',function(){
        //   $(this).html('<span class="iconify" data-icon="ant-design:close-outlined"></span>')
        // })
    </script>

    @yield('scripts')
</body>

</html>
