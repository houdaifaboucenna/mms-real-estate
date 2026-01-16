@extends('admin.layouts.app')

@section('pageTitle',__('admin.faq'))

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
          {{ isset($faq) ?
            __('admin.edit_question')
            : __('admin.add_question')
          }}
        </h2>

        <form method="post" action="{{ isset($faq) ? route('faq.update',$faq) : route('faq.store') }}">
          @csrf
          @if (isset($faq))
              @method('PUT')
          @endif

          {{-- Question --}}
          <div class="form-group">
            <label for="title">{{ __('admin.question')}}</label>
            <span class="asterix">*</span>
            <ul class="nav nav-tabs" id="questionTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="enQst-tab" data-toggle="tab" href="#enQst" role="tab" aria-controls="enQst" aria-selected="true">{{__('admin.en')}}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="arQst-tab" data-toggle="tab" href="#arQst" role="tab" aria-controls="arQst" aria-selected="false">{{__('admin.ar')}}</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="enQst" role="tabpanel" aria-labelledby="enQst-tab">
                <input id="question" class="form-control" type="text" name="question" value="{{ isset($faq) ? $faq->question : "" }}" required>
              </div>
              <div class="tab-pane fade" id="arQst" role="tabpanel" aria-labelledby="arQst-tab">
                <input id="question_ar" class="form-control" type="text" name="question_ar" value="{{ isset($faq) ? $faq->question_ar : "" }}" required>
              </div>
            </div>

          </div>

          {{-- Content --}}
          <div class="form-group">
            <label for="content">{{ __('admin.answer')}}</label>
            <span class="asterix">*</span>
            <ul class="nav nav-tabs" id="answerTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="enAns-tab" data-toggle="tab" href="#enAns" role="tab" aria-controls="enAns" aria-selected="true">{{__('admin.en')}}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="arAns-tab" data-toggle="tab" href="#arAns" role="tab" aria-controls="arAns" aria-selected="false">{{__('admin.ar')}}</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="enAns" role="tabpanel" aria-labelledby="enAns-tab">
                <textarea id="content"  name="answer" rows="5">{{ isset($faq) ? $faq->answer : ""}}</textarea>
              </div>
              <div class="tab-pane fade" id="arAns" role="tabpanel" aria-labelledby="arAns-tab">
                <textarea id="content_ar"  name="answer_ar" rows="5">{{ isset($faq) ? $faq->answer_ar : ""}}</textarea>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="show_home">{{__('admin.show_home')}}</label>
            <select class="custom-select" name="show_home" id="show_home">
              <option value="0" selected>{{__('admin.disabled')}}</option>
              <option value="1">{{__('admin.enabled')}}</option>
            </select>
          </div>

          <button type="submit" class="btn btn-info">
            @isset($faq)
              <i class="fas fa-sync"></i>
            @else
              <i class="fa fa-plus" aria-hidden="true"></i>
            @endisset
            {{ isset($faq) ?
              __('admin.update')
              : __('admin.add')
            }}
          </button>
        </form>

      </div>
    </div>
  </div>
@endsection


