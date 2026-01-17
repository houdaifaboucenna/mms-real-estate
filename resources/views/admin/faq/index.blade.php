@extends('admin.layouts.app')

@section('pageTitle',__('admin.faq'))

@section('content')

  <div class="app-content index pt-3 p-md-3 p-lg-4">
    <div class="container-xl">

      {{-- Show success message --}}
      @if (session('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
      @endif

      {{-- Head --}}
      <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
              <h1 class="app-page-title mb-0">{{ __('admin.faq') }}</h1>
        </div>

        <div class="col-auto">
          <div class="page-utilities">
            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">

              <div class="col-auto">
                <a class="btn app-btn-secondary" href="{{ route('faq.create') }}">
                  <i class="fa fa-plus mx-1" aria-hidden="true"></i>
                  {{ __('admin.add_question') }}
                </a>
              </div>

            </div>
          </div><!--//table-utilities-->
        </div><!--//col-auto-->
      </div>

      {{-- Table --}}
      <div class="tab-content" id="posts-table-tab-content">
            <div class="tab-pane fade show active" id="posts-all" role="tabpanel" aria-labelledby="posts-all-tab">
              <div class="app-card app-card-orders-table shadow-sm mb-5">
                <div class="app-card-body">
                  <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                      <thead>
                        <tr>
                          <th class="cell">{{ __('admin.number') }}</th>
                          <th class="cell">{{ __('admin.question') }}</th>
                          <th class="cell">{{ __('admin.answer') }}</th>
                          <th class="cell">{{ __('admin.show_home') }}</th>
                          <th class="cell">{{ __('admin.actions') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($faqs as $key => $faq)
                          <tr>
                            <td class="cell">{{ $key+1 }}</td>
                            <td class="cell">{{ $faq->question }}</td>
                            <td class="cell">{!! $faq->answer !!}</td>
                            <td class="cell">
                              @if ($faq->show_home)
                                {{ __('admin.enabled') }}
                              @else
                                {{ __('admin.disabled') }}
                              @endif
                            </td>
                            <td class="cell">
                                <span class="float-right">
                                  <form method="post" action="{{ route('faq.destroy',$faq->id) }}">
                                      @csrf
                                      @method('DELETE')
                                      <button class="delete-btn btn-sm app-btn-secondary" data-toggle="tooltip" title="{{ __('admin.delete') }}">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                      </button>
                                  </form>
                                </span>
                                <span class="float-right mr-1">
                                  <form method="get" action="{{ route('faq.edit', $faq) }}">
                                      @csrf
                                      <button class="btn-sm app-btn-secondary edit-btn" data-toggle="tooltip" title="{{ __('admin.edit') }}">
                                        <i class="fas fa-edit"></i>
                                      </button>
                                  </form>
                                </span>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div><!--//table-responsive-->
                </div><!--//app-card-body-->
              </div><!--//app-card-->
            </div><!--//tab-pane-->


      </div>

    </div>
  </div>
@endsection

