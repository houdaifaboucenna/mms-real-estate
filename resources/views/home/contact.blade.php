@extends('layouts.app')

@section('pageTitle', __('home.contactus'))

@section('content')
  <div class="container" id="contact">
    <div class="row justify-content-center">

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

      <div class="col-md-8">
        <div class="address">
          <h3>{{__('home.address')}}</h3>
          <p><span class="iconify" data-icon="fontisto:map-marker-alt"></span>{{__('home.adrs')}}</p>
        </div>
        <div class="contact">
          <ul>
            <li class="n-tel">
              <a href="tel:{{setting('phone')}}">
                <span class="iconify" data-icon="bi:telephone-fill"></span>
                <span class="num">{{setting('phone')}}</span>
              </a>
            </li>
            <li class="n-whatsapp">
              <a href="https://wa.me/{{str_replace(' ', '', setting('whatsapp'))}}" target="_blank">
                <span class="iconify" data-icon="bi:whatsapp"></span>
                <span class="num">{{setting('whatsapp')}}</span>
              </a>
            </li>
            <li class="n-email">
              <a href="mailto:{{setting('email')}}">
                <span class="iconify" data-icon="carbon:email"></span>
                <span class="num">{{setting('email')}}</span>
              </a>
            </li>
          </ul>
        </div>
        <div class="map">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2424.2872037611833!2d28.683593633557063!3d41.011689714781575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14caa09a133a8ac5%3A0xef56e6d6a8ae2a8d!2sNam%C4%B1k%20Kemal%2C%20Haramidere%20Yolu%2C%2034513%20Esenyurt%2F%C4%B0stanbul%2C%20Turkey!5e0!3m2!1sen!2sdz!4v1640074649258!5m2!1sen!2sdz"
            width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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