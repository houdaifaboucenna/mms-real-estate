@extends('admin.layouts.app')

@section('pageTitle',__('admin.settings'))

@section('content')

  <div class="app-content index pt-3 p-md-3 p-lg-4">
    <div class="container-xl p-3 settings create-page">

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

            {{-- Head --}}
            <div class="row g-3 mb-4 align-items-center justify-content-between">
              <div class="col-auto">
                  <h1 class="app-page-title mb-0">{{ __('admin.all_settings') }}</h1>
              </div>

              <div class="col-auto">
                <div class="page-utilities">
                  <div class="row g-2 justify-content-start justify-content-md-end align-items-center">

                    <div class="col-auto">
                      <a class="btn app-btn-secondary" onclick="document.getElementById('form1').submit();">
                        <i class="fas fa-sync"></i>
                        {{ __('admin.update') }}
                      </a>
                    </div>

                  </div>
                </div><!--//table-utilities-->
              </div><!--//col-auto-->
            </div>

            <hr>

            <form method="post" action="{{route('settings.update',$settings)}}" enctype="multipart/form-data" id="form1">
              @csrf
              @method('PUT')

              <div class="clone-item d-none">
                    <div class="slider-item add">
                      <img src="" class="preview d-none" alt="">
                      <label class="file_img" href="#">
                        <input type="file" name="home_imgs[]" class="form-control" onchange="uploadImg.call(this)">
                      </label>
                    </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <h5>{{__('admin.homeslider')}}</h5>
                    <div class="slider">

                      @if ($settings->home_imgs)
                        @foreach (json_decode($settings->home_imgs) as $img)
                          <div class="slider-item">
                            <img src="{{asset('/storage/'.$img)}}" alt="">
                            <span class="imgsrc d-none" data-src="{{$img}}"></span>
                            <a class="del-btn" href="#">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8Z"/>
                              </svg>
                            </a>
                          </div>
                        @endforeach
                      @endif

                      <div class="slider-item add">
                        <a class="add-btn" href="#">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                          </svg>
                        </a>
                      </div>

                    </div>
                </div>
              </div>

              <hr>

              <div class="row infos" id="social">
                <div class="col-md-12">
                  <h5>{{__('admin.sociallinks')}}</h5>
                  <div class="form-group d-flex align-items-center">
                    <label for="facebook">{{ __('admin.facebook')}}<span class="asterix">*</span></label>
                    <input id="facebook" class="form-control" type="url" name="facebook" value="{{ $settings->facebook }}">
                  </div>
                  <div class="form-group d-flex align-items-center">
                    <label for="instagram">{{ __('admin.instagram')}}<span class="asterix">*</span></label>
                    <input id="instagram" class="form-control" type="url" name="instagram" value="{{ $settings->instagram }}">
                  </div>
                  <div class="form-group d-flex align-items-center">
                    <label for="twitter">{{ __('admin.twitter')}}<span class="asterix">*</span></label>
                    <input id="twitter" class="form-control" type="url" name="twitter" value="{{ $settings->twitter }}">
                  </div>
                  <div class="form-group d-flex align-items-center">
                    <label for="youtube">{{ __('admin.youtube')}}<span class="asterix">*</span></label>
                    <input id="youtube" class="form-control" type="url" name="youtube" value="{{ $settings->youtube }}">
                  </div>
                  <div class="form-group d-flex align-items-center">
                    <label for="telegram">{{ __('admin.telegram')}}<span class="asterix">*</span></label>
                    <input id="telegram" class="form-control" type="url" name="telegram" value="{{ $settings->telegram }}">
                  </div>
                </div>
              </div>

              <hr>

              <div class="row infos" id="meta_info">
                <div class="col-md-12">
                  <h5>{{__('admin.meta_info')}}</h5>
                  <div class="form-group">
                    <div for="short">{{ __('admin.shortmeta')}}</div>
                    <ul class="nav nav-tabs" id="shortTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="enShort-tab" data-toggle="tab" href="#enShort" role="tab" aria-controls="enShort" aria-selected="true">{{__('admin.en')}}</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="arShort-tab" data-toggle="tab" href="#arShort" role="tab" aria-controls="arShort" aria-selected="false">{{__('admin.ar')}}</a>
                      </li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="enShort" role="tabpanel" aria-labelledby="enShort-tab">
                        <input id="short" class="form-control" type="text" name="desc" value="{{ isset($settings) ? $settings->desc : "" }}">
                      </div>
                      <div class="tab-pane fade" id="arShort" role="tabpanel" aria-labelledby="arShort-tab">
                        <input id="short_ar" class="form-control" type="text" name="desc_ar" value="{{ isset($settings) ? $settings->desc_ar : "" }}">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div for="keywords">{{ __('admin.keywords')}}</div>
                    <ul class="nav nav-tabs" id="KeyTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="enKey-tab" data-toggle="tab" href="#enKey" role="tab" aria-controls="enKey" aria-selected="true">{{__('admin.en')}}</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="arKey-tab" data-toggle="tab" href="#arKey" role="tab" aria-controls="arKey" aria-selected="false">{{__('admin.ar')}}</a>
                      </li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="enKey" role="tabpanel" aria-labelledby="enKey-tab">
                        <input id="keywords" class="form-control" type="text" name="keywords" value="{{ isset($settings) ? $settings->keywords : "" }}" placeholder="key1, key2, key3, ....">
                      </div>
                      <div class="tab-pane fade" id="arKey" role="tabpanel" aria-labelledby="arKey-tab">
                        <input id="keywords_ar" class="form-control" type="text" name="keywords_ar" value="{{ isset($settings) ? $settings->keywords_ar : "" }}" placeholder="key1, key2, key3, ....">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <hr>

              <div class="row infos" id="contact_info">
                <div class="col-md-12">
                  <h5>{{__('admin.contact_info')}}</h5>
                  <div class="form-group d-flex align-items-center">
                    <label for="whatsapp">{{ __('admin.whatsapp')}}<span class="asterix">*</span></label>
                    <input id="whatsapp" class="form-control" type="tel" name="whatsapp" value="{{ $settings->whatsapp }}">
                  </div>
                  <div class="form-group d-flex align-items-center">
                    <label for="phone">{{ __('admin.phone')}}<span class="asterix">*</span></label>
                    <input id="phone" class="form-control" type="tel" name="phone" value="{{ $settings->phone }}">
                  </div>
                  <div class="form-group d-flex align-items-center">
                    <label for="email">{{ __('admin.email')}}<span class="asterix">*</span></label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ $settings->email }}">
                  </div>
                </div>
              </div>



              <button type="submit" class="btn btn-info">
                <i class="fas fa-sync"></i>
                {{__('admin.update')}}
              </button>

            </form>

          </div>
        </div>

    </div>
  </div>

@endsection

@section('scripts')

<script>

  function uploadImg() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    let reader = new FileReader();
    reader.onload = (e) => {
      $(this).parent().siblings("img.preview").attr('src', e.target.result).removeClass('d-none');
      $(this).parent().addClass('d-none')
    }
    reader.readAsDataURL(this.files[0]);

  };

  $(".slider-item .add-btn").click(function(e){
    e.preventDefault()
    var html = $(".clone-item").html();
    $(".slider .slider-item.add:last").before(html);
  });

  $(".slider-item .del-btn").on('click',function(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var image = $(this).siblings('.imgsrc').attr('data-src');
    var current = $(this)
    swal({
      title: 'Confirm deleting ?',
      icon: 'warning',
      buttons: ["No", "Yes"],
    }).then(function(value) {
      if(value) {
        $.ajax({
          type: "POST",
          url: "/delete_img",
          data: {_token: CSRF_TOKEN, img:image},
          dataType: "json",
          success: function (response) {
              current.parent().remove();
            }
        })
      }
    })

  });


</script>

@endsection
