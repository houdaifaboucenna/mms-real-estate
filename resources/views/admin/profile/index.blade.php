@extends('admin.layouts.app')

@section('pageTitle',__('admin.profile'))

@section('content')


  <div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl p-3 create-page">
      <div class="row">
        <div class="col-md text-right">

          {{-- Show success message --}}
          @if (session('success'))
            <div class="alert alert-success" role="alert">
              {{session('success')}}
            </div>
          @endif

          {{-- Show error --}}
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

          <h2 class="text-center mb-4">
            {{__('admin.edit_profile')}}
          </h2>

          <form method="post" action="{{ route('profile.update',$profile) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">{{ __('admin.name')}}</label>
                  <span class="asterix">*</span>
                  <input id="name" class="form-control" type="text" name="name" value="{{$user->name}}" disabled>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">{{ __('admin.email')}}</label>
                  <span class="asterix">*</span>
                  <input id="email" class="form-control" type="text" name="email" value="{{$user->email}}" disabled>
                </div>
              </div>

            </div>

            <div class="form-group">
              <label for="username">{{ __('admin.username')}}</label>
              <span class="asterix">*</span>
              <input id="username" class="form-control" type="text" name="username" value="{{ $profile->username  }}" required>
            </div>

            <div class="form-group">
              <label for="bio">{{ __('admin.bio')}}</label>
              <textarea id="bio" class="form-control" name="bio" rows="5">{{  $profile->bio }}</textarea>
            </div>

            <div class="form-group">
              <label for="image">{{ __('admin.image')}}</label>
              <img class="profile-img" src="{{  asset('/storage/'.$profile->image) }}" alt="">
              <input id="image" class="form-control-file" type="file" name="image">
            </div>

            <button type="submit" class="btn btn-info">
              @isset($profile)
                <i class="fas fa-sync"></i>
              @else
                <i class="fa fa-plus" aria-hidden="true"></i>
              @endisset
              {{ isset($profile) ?
                __('admin.update')
                : __('admin.add')
              }}
            </button>
          </form>

        </div>
      </div>
    </div>
  </div>

@endsection
