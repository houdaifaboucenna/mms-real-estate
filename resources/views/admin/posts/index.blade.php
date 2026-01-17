@extends('admin.layouts.app')

@section('pageTitle',__('admin.articles'))

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
              <h1 class="app-page-title mb-0">{{ __('admin.all_articles') }}</h1>
        </div>

        <div class="col-auto">
          <div class="page-utilities">
            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">

              <div class="col-auto">
                <a class="btn app-btn-secondary" href="{{ route('posts.create') }}">
                  <i class="fa fa-plus mx-1" aria-hidden="true"></i>
                  {{ __('admin.add_article') }}
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
                          <th class="cell">{{ __('admin.title') }}</th>
                          <th class="cell">{{ __('admin.image') }}</th>
                          <th class="cell">{{ __('admin.writer') }}</th>
                          <th class="cell">{{ __('admin.date') }}</th>
                          <th class="cell">{{ __('admin.actions') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($posts as $key => $post)
                          <tr>
                            <td class="cell">{{ $key+1 }}</td>
                            <td class="cell">{{ $post->title }}</td>
                            <td class="cell image"><img src="{{ asset('/storage/'.$post->image) }}" alt="" width="150"></td>
                            <td class="cell">{{ $post->user->name }}</td>
                            <td class="cell">{{ $post->created_at->format('d/m/Y') }}</td>
                            <td class="cell">
                                <span class="float-right">
                                  <form method="post" action="{{ route('posts.destroy',$post->id) }}">
                                      @csrf
                                      @method('DELETE')
                                      <button class="delete-btn btn-sm app-btn-secondary" data-toggle="tooltip" title="{{ __('admin.delete') }}">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                      </button>
                                  </form>
                                </span>
                                <span class="float-right mr-1">
                                  <form method="get" action="{{ route('posts.edit', $post) }}">
                                      @csrf
                                      <button class="btn-sm app-btn-secondary edit-btn" data-toggle="tooltip" title="{{ __('admin.edit') }}">
                                        <i class="fas fa-edit"></i>
                                      </button>
                                  </form>
                                </span>
                                <span class="float-right mr-1">
                                  <a class="btn-sm app-btn-secondary show-btn" href="#show{{ $key+1 }}" data-toggle="modal" title="{{ __('admin.preview') }}">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                  </a>
                                  <div id="show{{ $key+1 }}" class="modal fade md-estate md-post" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="my-modal-title">{{ __('admin.article') }} #{{ $key+1 }}</h5>
                                          <button class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <div class="row">
                                            <div class="col-md-12">
                                              <p><b>{{ __('admin.title') }}:</b> <span>{{ $post->title }}</span></p>
                                            </div>
                                            <div class="col-md-6">
                                              <p><b>{{ __('admin.writer') }}:</b> <span>{{ $post->user->name }}</span></p>
                                            </div>
                                            <div class="col-md-6">
                                              <p><b>{{ __('admin.date') }}:</b> <span>{{ $post->created_at->format('d/m/Y') }}</span></p>
                                            </div>
                                            <div class="col-md-12">
                                              <p><b>{{ __('admin.image') }}:</b></p>
                                              <div id="post{{ $key+1 }}" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                      <img class="d-block w-100" src="{{ asset('/storage/'.$post->image) }}" alt="">
                                                    </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-md-12 mt-4">
                                              <p><b>{{ __('admin.content') }}:</b> <span>{!! $post->content !!}</span></p>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
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

