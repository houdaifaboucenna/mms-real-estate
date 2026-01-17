@extends('admin.layouts.app')

@section('pageTitle',__('admin.article'))

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
          {{ isset($post) ?
            __('admin.edit_article')
            : __('admin.add_article')
          }}
        </h2>

        <form method="post" action="{{ isset($post) ? route('posts.update',$post) : route('posts.store') }}" enctype="multipart/form-data">
          @csrf
          @if (isset($post))
              @method('PUT')
          @endif

          {{-- Title --}}
          <div class="form-group">
            <label for="title">{{ __('admin.title') }}</label>
            <span class="asterix">*</span>
            <ul class="nav nav-tabs" id="titleTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="enTitle-tab" data-toggle="tab" href="#enTitle" role="tab" aria-controls="enTitle" aria-selected="true">{{ __('admin.en') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="arTitle-tab" data-toggle="tab" href="#arTitle" role="tab" aria-controls="arTitle" aria-selected="false">{{ __('admin.ar') }}</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="enTitle" role="tabpanel" aria-labelledby="enTitle-tab">
                <input id="title" class="form-control" type="text" name="title" value="{{ isset($post) ? $post->title : "" }}" required>
              </div>
              <div class="tab-pane fade" id="arTitle" role="tabpanel" aria-labelledby="arTitle-tab">
                <input id="title_ar" class="form-control" type="text" name="title_ar" value="{{ isset($post) ? $post->title_ar : "" }}" required>
              </div>
            </div>

          </div>

          {{-- Slug --}}
          <div class="form-group">
            <label for="slug">Slug</label>
            <input id="slug" class="form-control" type="text" name="slug" value="{{ isset($post) ? $post->slug : "" }}" placeholder="example-1">
          </div>

          {{-- Meta Description --}}
          <div class="form-group">
            <label for="short">{{ __('admin.shortmeta') }}</label>
            <ul class="nav nav-tabs" id="shortTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="enShort-tab" data-toggle="tab" href="#enShort" role="tab" aria-controls="enShort" aria-selected="true">{{ __('admin.en') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="arShort-tab" data-toggle="tab" href="#arShort" role="tab" aria-controls="arShort" aria-selected="false">{{ __('admin.ar') }}</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="enShort" role="tabpanel" aria-labelledby="enShort-tab">
                <input id="short" class="form-control" type="text" name="short" value="{{ isset($post) ? $post->short : "" }}">
              </div>
              <div class="tab-pane fade" id="arShort" role="tabpanel" aria-labelledby="arShort-tab">
                <input id="short_ar" class="form-control" type="text" name="short_ar" value="{{ isset($post) ? $post->short_ar : "" }}">
              </div>
            </div>
          </div>

          {{-- Keywords --}}
          <div class="form-group">
            <label for="keywords">{{ __('admin.keywords') }}</label>
            <ul class="nav nav-tabs" id="KeyTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="enKey-tab" data-toggle="tab" href="#enKey" role="tab" aria-controls="enKey" aria-selected="true">{{ __('admin.en') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="arKey-tab" data-toggle="tab" href="#arKey" role="tab" aria-controls="arKey" aria-selected="false">{{ __('admin.ar') }}</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="enKey" role="tabpanel" aria-labelledby="enKey-tab">
                <input id="keywords" class="form-control" type="text" name="keywords" value="{{ isset($post) ? $post->keywords : "" }}" placeholder="key1, key2, key3, ....">
              </div>
              <div class="tab-pane fade" id="arKey" role="tabpanel" aria-labelledby="arKey-tab">
                <input id="keywords_ar" class="form-control" type="text" name="keywords_ar" value="{{ isset($post) ? $post->keywords_ar : "" }}" placeholder="key1, key2, key3, ....">
              </div>
            </div>
          </div>

          {{-- Content --}}
          <div class="form-group">
            <label for="content">{{ __('admin.content') }}</label>
            <span class="asterix">*</span>
            <ul class="nav nav-tabs" id="contentTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="enContent-tab" data-toggle="tab" href="#enContent" role="tab" aria-controls="enContent" aria-selected="true">{{ __('admin.en') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="arContent-tab" data-toggle="tab" href="#arContent" role="tab" aria-controls="arContent" aria-selected="false">{{ __('admin.ar') }}</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="enContent" role="tabpanel" aria-labelledby="enContent-tab">
                <textarea id="content"  name="content" rows="5">{{ isset($post) ? $post->content : "" }}</textarea>
              </div>
              <div class="tab-pane fade" id="arContent" role="tabpanel" aria-labelledby="arContent-tab">
                <textarea id="content_ar"  name="content_ar" rows="5">{{ isset($post) ? $post->content_ar : "" }}</textarea>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="image">{{ __('admin.image') }}</label>
            <img class="post-img" src="{{ isset($post) ? asset('/storage/'.$post->image) : "" }}" alt="">
            <input id="image" class="form-control-file" type="file" name="image" onchange="uploadImg.call(this)">
          </div>

          <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
          <button type="submit" class="btn btn-info">
            @isset($post)
              <i class="fas fa-sync"></i>
            @else
              <i class="fa fa-plus" aria-hidden="true"></i>
            @endisset
            {{ isset($post) ?
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
          $(this).siblings(".post-img").attr('src', e.target.result).removeClass('d-none');
        }
        reader.readAsDataURL(this.files[0]);

      };
    </script>
@endsection

