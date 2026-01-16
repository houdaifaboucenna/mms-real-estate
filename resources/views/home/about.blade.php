@extends('layouts.app')

@section('pageTitle', __('home.about') )

@section('content')
<div class="container" id="about">
    <div class="row justify-content-center">
        <div class="col-md-12 p-0">
          <img src="{{asset('images/background/about1.png')}}" alt="" class="back">
          {{-- <div class="overlay"></div> --}}
          <div class="content">
            <div>
              <h1>{{__('home.who')}}</h1>
              <p>
                {{__('home.who_txt')}}
              </p>
            </div>
              <div class="d-flex">
                <div>
                  <h2>{{__('home.vision')}}</h2>
                  <p>
                    {{__('home.vision_txt')}}
                  </p>
                </div>
                <img src="{{asset('images/background/about2.png')}}" alt="" class="d-block" style="height:350px">
              </div>
              <div class="d-flex">
                <img src="{{asset('images/background/about3.png')}}" alt="" class="d-block" style="height:350px">
                <div>
                  <h2>{{__('home.mission')}}</h2>
                  <p>
                    {{__('home.mission_txt')}}
                  </p>
                </div>
              </div>
          </div>
        </div>
    </div>
</div>
@endsection
