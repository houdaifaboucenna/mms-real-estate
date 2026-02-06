@extends('admin.layouts.app')

@section('pageTitle', __('admin.comments'))

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
                    <h1 class="app-page-title mb-0">{{ __('admin.all_comments') }}</h1>
                </div>
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
                                            <th class="cell">{{ __('admin.name') }}</th>
                                            <th class="cell">{{ __('admin.email') }}</th>
                                            <th class="cell">{{ __('admin.image') }}</th>
                                            <th class="cell">{{ __('admin.comment') }}</th>
                                            <th class="cell">{{ __('admin.date') }}</th>
                                            <th class="cell">{{ __('admin.article') }}</th>
                                            <th class="cell">{{ __('admin.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($comments as $key => $comment)
                                            <tr>
                                                <td class="cell">{{ $key + 1 }}</td>
                                                <td class="cell">{{ $comment->name }}</td>
                                                <td class="cell">{{ $comment->email }}</td>
                                                <td class="cell"><img src="{{ getGravatar($comment->email) }}}"
                                                        alt="" class="user-img"></td>
                                                <td class="cell">{{ $comment->content }}</td>
                                                <td class="cell">{{ $comment->created_at->format('d/m/Y') }}</td>
                                                <td class="cell"><a
                                                        href="{{ route('posts.show', $comment->post->id) }}">{{ $comment->post->title }}</a>
                                                </td>
                                                <td>
                                                    <span class="float-right">
                                                        <form method="post"
                                                            action="{{ route('comments.destroy', $comment->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="delete-btn btn-sm app-btn-secondary"
                                                                data-toggle="tooltip" title="{{ __('admin.delete') }}">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
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
