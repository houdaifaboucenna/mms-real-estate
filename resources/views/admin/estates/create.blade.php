@extends('admin.layouts.app')

@section('pageTitle',__('admin.estate'))

@section('content')
  <div class="container p-3 create-page">
    <div class="row">
      <div class="col-md text-right">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 class="text-center">
          {{ isset($estate) ?
            __('admin.edit_estate')
            : __('admin.add_estate')
          }}
        </h2>

        <form method="post" action="{{ isset($estate) ? route('estates.update',$estate) : route('estates.store') }}" enctype="multipart/form-data">

          @csrf
          @if (isset($estate))
              @method('PUT')
          @endif

          {{-- Title --}}
          <div class="form-group">
            <label for="title">{{ __('admin.title')}}</label>
            <span class="asterix">*</span>
            <ul class="nav nav-tabs" id="titleTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="enTitle-tab" data-toggle="tab" href="#enTitle" role="tab" aria-controls="enTitle" aria-selected="true">{{__('admin.en')}}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="arTitle-tab" data-toggle="tab" href="#arTitle" role="tab" aria-controls="arTitle" aria-selected="false">{{__('admin.ar')}}</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="enTitle" role="tabpanel" aria-labelledby="enTitle-tab">
                <input id="title" class="form-control" type="text" name="title" value="{{ isset($estate) ? $estate->title : "" }}" required>
              </div>
              <div class="tab-pane fade" id="arTitle" role="tabpanel" aria-labelledby="arTitle-tab">
                <input id="title_ar" class="form-control" type="text" name="title_ar" value="{{ isset($estate) ? $estate->title_ar : "" }}" required>
              </div>
            </div>
          </div>

          {{-- Slug --}}
          <div class="form-group">
            <label for="slug">Slug</label>
            <input id="slug" class="form-control" type="text" name="slug" value="{{ isset($estate) ? $estate->slug : "" }}" placeholder="estate-1">
          </div>

          {{-- Meta Description --}}
          <div class="form-group">
            <label for="short">{{ __('admin.shortmeta')}}</label>
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
                <input id="short" class="form-control" type="text" name="short" value="{{ isset($estate) ? $estate->short : "" }}">
              </div>
              <div class="tab-pane fade" id="arShort" role="tabpanel" aria-labelledby="arShort-tab">
                <input id="short_ar" class="form-control" type="text" name="short_ar" value="{{ isset($estate) ? $estate->short_ar : "" }}">
              </div>
            </div>
          </div>

          {{-- Keywords --}}
          <div class="form-group">
            <label for="keywords">{{ __('admin.keywords')}}</label>
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
                <input id="keywords" class="form-control" type="text" name="keywords" value="{{ isset($estate) ? $estate->keywords : "" }}" placeholder="key1, key2, key3, ....">
              </div>
              <div class="tab-pane fade" id="arKey" role="tabpanel" aria-labelledby="arKey-tab">
                <input id="keywords_ar" class="form-control" type="text" name="keywords_ar" value="{{ isset($estate) ? $estate->keywords_ar : "" }}" placeholder="key1, key2, key3, ....">
              </div>
            </div>

          </div>

          {{-- Content --}}
          <div class="form-group">
            <label for="content">{{ __('admin.content')}}</label>
            <span class="asterix">*</span>
            <ul class="nav nav-tabs" id="contentTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="enContent-tab" data-toggle="tab" href="#enContent" role="tab" aria-controls="enContent" aria-selected="true">{{__('admin.en')}}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="arContent-tab" data-toggle="tab" href="#arContent" role="tab" aria-controls="arContent" aria-selected="false">{{__('admin.ar')}}</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="enContent" role="tabpanel" aria-labelledby="enContent-tab">
                <textarea id="content"  name="content" rows="5">{{ isset($estate) ? $estate->content : ""}}</textarea>
              </div>
              <div class="tab-pane fade" id="arContent" role="tabpanel" aria-labelledby="arContent-tab">
                <textarea id="content_ar"  name="content_ar" rows="5">{{ isset($estate) ? $estate->content_ar : ""}}</textarea>
              </div>
            </div>
          </div>

          <label class="price">Price</label>
          <span class="asterix">*</span>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group-inline d-flex">
                <input id="min" class="form-control" type="number" name="min" placeholder="MIN  20000" value="@isset($estate){{$estate->min}}@endisset"><span class="currency">$</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group d-flex">
                <input id="max" class="form-control" type="number" name="max" placeholder="MAX 150000" value="@isset($estate){{$estate->max}}@endisset"><span class="currency">$</span>
              </div>
            </div>
          </div>

          <label class="address">Address</label>
          <span class="asterix">*</span>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group-inline d-flex">
                <select id="city" class="form-control" name="city">
                  @foreach ($cities as $key=>$city)
                      <option value="{{$key}}" @isset($estate) @if ($city == $cities[$estate->city])
                          selected
                      @endif @endisset>{{$city}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group d-flex">
                <input type="hidden" class="town-id" value="@isset($estate){{$estate->town}}@endisset">
                <select id="town" class="form-control" name="town">
                      <option value="1">Not selected</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="type">{{ __('admin.type')}}</label>
            <span class="asterix">*</span>
            <select id="type" class="form-control" name="type">
              @foreach ($types as $key=>$type)
                  <option value="{{$key}}" @isset($estate) @if ($type == $types[$estate->type])
                      selected
                  @endif @endisset>{{$type}}</option>
              @endforeach
            </select>
          </div>

          {{-- Clone DIv --}}
          <div class="clone-item d-none">
              <div class="slider-item add">
                <img src="" class="preview d-none" alt="">
                <label class="file_img" href="#">
                  <input type="file" name="images[]" class="form-control" onchange="uploadImg.call(this)">
                </label>
              </div>
          </div>

          {{-- Images --}}
          <div class="row">
            <div class="col-md-12">
              <label for="images">{{ __('admin.image')}}</label>
              <div class="slider">
                @isset ($images)
                  @foreach ($images as $img)
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
                @else
                  <div class="slider-item add">
                    <img src="" class="preview d-none" alt="">
                    <label class="file_img" href="#">
                      <input type="file" name="images[]" class="form-control" onchange="uploadImg.call(this)">
                    </label>
                  </div>
                @endisset

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

          <button type="submit" class="btn btn-info">
            @isset($estate)
              <i class="fas fa-sync"></i>
            @else
              <i class="fa fa-plus" aria-hidden="true"></i>
            @endisset
            {{ isset($estate) ?
              __('admin.update')
              : __('admin.add')
            }}
          </button>
        </form>

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
    var id = null;
    @isset($estate)
      id = {{ $estate->id }};
    @endisset
    var current = $(this)
    swal({
      title: 'Confirm deleting ?',
      icon: 'warning',
      buttons: ["No", "Yes"],
    }).then(function(value) {
      if(value) {
        $.ajax({
          type: "POST",
          url: "/del_estateimg",
          data: {_token: CSRF_TOKEN, img:image,estate:id},
          dataType: "json",
          success: function (response) {
            console.log(response)
            current.parent().remove();
          }
        })
      }
    })

  });

  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  var towns = $("#town")
  var city = $("#city option:eq("+ ($("#city").val()-1) +")").text();
  var town_id = Number($(".town-id").val());
  $.ajax({
      type: "POST",
      url: "/towns",
      data: {_token: CSRF_TOKEN, city:city},
      dataType: "json",
      success: function (response) {
        var options = ""
        for (let i = 0; i < response.towns.length; i++) {
          if (town_id == (i+1)) {
            options += "<option value='"+ (i+1) + "' selected>"+response.towns[i]+"</option>"
          } else {
            options += "<option value='"+ (i+1) +  "'>"+response.towns[i]+"</option>"
          }
        }
        towns.html(options)
      }
  });


  $("#city").change(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var towns = $("#town")
    var city = $("#city option:eq("+ ($(this).val()-1) +")").text();
    $.ajax({
      type: "POST",
      url: "/towns",
      data: {_token: CSRF_TOKEN, city:city},
      dataType: "json",
      success: function (response) {
        var options = ""
        for (let i = 0; i < response.towns.length; i++) {
          options += "<option value='"+ (i+1) +"'>"+response.towns[i]+"</option>"
        }
        towns.html(options)
      }
    });

  });


</script>

@endsection
