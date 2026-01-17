@extends('layouts.app')

@section('pageTitle', __('home.faq'))

@section('content')
  <div class="container" id="faq_p">
    <div class="row justify-content-center">
      <div class="col-md-8 p-0">

        {{-- Show success message --}}
        @if (session('success'))
          <div class="alert alert-success" role="alert">
            {{session('success')}}
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

        {{-- FAQ --}}
        <div class="row" id="faq-row">
          <div class="col-md">
            <div class="c-col">
              <div class="row">
                <div class="col-md-12 position-relative">
                  <h2>{{__('home.faq')}}</h2>
                </div>
                <div class="col-md-12">
                  <div id="faqAcc" role="tablist" aria-multiselectable="true" class="mt-2">
                    @foreach ($faqs as $key => $faq)
                      <div class="card">
                        <div class="card-header" role="tab">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-parent="#faqAcc" href="#faq-{{$key + 1}}" aria-expanded="false"
                              aria-controls="faq-{{$key + 1}}" class="collapsed">
                              <span class="iconify" data-icon="bi:bookmark-plus"></span>
                              @if (isLang('en'))
                                {{$faq->question}}
                              @else
                                {{$faq->question_ar}}
                              @endif
                            </a>
                          </h5>
                        </div>
                        <div id="faq-{{$key + 1}}" class="collapse in" role="tabpanel">
                          <div class="card-body">
                            @if (isLang('en'))
                              {!!$faq->answer!!}
                            @else
                              {!!$faq->answer_ar!!}
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

      </div>

      <div class="col-md-4">

        {{-- Contact Form --}}
        <form action="{{route('contacts.store')}}" id="c-form" method="POST" class="text-center">
          @csrf
          <h3>{{__('home.getin')}}</h3>
          <p>{{__('home.fillin')}}</p>

          <div class="form-group">
            <input id="name" class="form-control" type="text" name="name" placeholder="{{__('home.name')}}">
          </div>

          <div class="form-group">
            <input id="email" class="form-control" type="email" name="email" placeholder="{{__('home.email')}}">
          </div>

          <div class="form-group">
            <input id="tel" class="form-control" type="tel" name="phone" placeholder="{{__('home.phone')}}">
          </div>

          <div class="form-group">
            <textarea id="message" class="form-control" name="message" rows="4"
              placeholder="{{__('home.message')}}"></textarea>
          </div>

          <button type="submit" class="btn btn-primary">{{__("home.contactus")}}</button>

        </form>

      </div>
    </div>
  </div>
@endsection