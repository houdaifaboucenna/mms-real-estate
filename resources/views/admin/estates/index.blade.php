@extends('admin.layouts.app')

@section('pageTitle', __('admin.estates'))

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
                    <h1 class="app-page-title mb-0">{{ __('admin.all_estates') }}</h1>
                </div>

                <div class="col-auto">
                    <div class="page-utilities">
                        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">

                            {{-- <div class="col-auto">
                  <form class="table-search-form row gx-1 align-items-center">
                      <div class="col-auto">
                          <input type="text" id="search-orders" name="searchorders" class="form-control search-orders" placeholder="Search">
                      </div>
                      <div class="col-auto">
                          <button type="submit" class="btn app-btn-secondary">Search</button>
                      </div>
                  </form>
                </div><!--//col--> --}}

                            <div class="col-auto">
                                <a class="btn app-btn-secondary" href="{{ route('estates.create') }}">
                                    <i class="fa fa-plus mx-1" aria-hidden="true"></i>
                                    {{ __('admin.add_estate') }}
                                </a>
                            </div>

                        </div>
                    </div><!--//table-utilities-->
                </div><!--//col-auto-->
            </div>

            <nav id="estates-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
                <a class="flex-sm-fill text-sm-center nav-link active" id="estate-all-tab" data-bs-toggle="tab"
                    href="#estate-all" role="tab" aria-controls="estate-all" aria-selected="true">All</a>
                @foreach ($types as $type)
                    <a class="flex-sm-fill text-sm-center nav-link" id="estate-{{ $type }}-tab" data-bs-toggle="tab"
                        href="#estate-{{ $type }}" role="tab" aria-controls="estate-{{ $type }}"
                        aria-selected="false">{{ $type }}</a>
                @endforeach
            </nav>

            {{-- Tables --}}
            <div class="tab-content" id="estates-table-tab-content">
                <div class="tab-pane fade show active" id="estate-all" role="tabpanel" aria-labelledby="estate-all-tab">
                    <div class="app-card app-card-orders-table shadow-sm mb-5">
                        <div class="app-card-body">
                            <div class="table-responsive">
                                <table class="table app-table-hover mb-0 text-left">
                                    <thead>
                                        <tr>
                                            <th class="cell">{{ __('admin.id') }}</th>
                                            <th class="cell">{{ __('admin.title') }}</th>
                                            <th class="cell">{{ __('admin.type') }}</th>
                                            <th class="cell">{{ __('admin.city') }}</th>
                                            <th class="cell">{{ __('admin.town') }}</th>
                                            <th class="cell">{{ __('admin.min') }}</th>
                                            <th class="cell">{{ __('admin.max') }}</th>
                                            <th class="cell">{{ __('admin.image') }}</th>
                                            <th class="cell">{{ __('admin.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($estates as $key => $estate)
                                            <tr>
                                                <td class="cell">#{{ $estate->id }}</td>
                                                <td class="cell"><span class="truncate">{{ $estate->title }}</span></td>
                                                <td class="cell">{{ $estate->type }}</td>
                                                <td class="cell">{{ $estate->city->name }}</td>
                                                <td class="cell town">{{ $estate->town->name }}</td>
                                                <td class="cell">{{ $estate->min }} $</td>
                                                <td class="cell">{{ $estate->max }} $</td>
                                                <td class="cell images">
                                                    {{-- @foreach (json_decode($estate->image) as $image)
                                                        <img src="{{ asset('/storage/' . $image) }}" alt="">
                                                    @endforeach --}}
                                                </td>
                                                <td class="cell">
                                                    <span class="float-right">
                                                        <form method="post"
                                                            action="{{ route('estates.destroy', $estate->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="delete-btn btn-sm app-btn-secondary"
                                                                data-toggle="tooltip" title="{{ __('admin.delete') }}">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                    </span>
                                                    <span class="float-right mr-1">
                                                        <form method="get" action="{{ route('estates.edit', $estate) }}">
                                                            @csrf
                                                            <button class="btn-sm app-btn-secondary edit-btn"
                                                                data-toggle="tooltip" title="{{ __('admin.edit') }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </form>
                                                    </span>
                                                    <span class="float-right mr-1">
                                                        <a class="btn-sm app-btn-secondary show-btn"
                                                            href="#show{{ $key + 1 }}" data-toggle="modal"
                                                            title="{{ __('admin.preview') }}">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                        <div id="show{{ $key + 1 }}" class="modal fade md-estate"
                                                            tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="my-modal-title">
                                                                            {{ __('admin.estate') }} #{{ $key + 1 }}
                                                                        </h5>
                                                                        <button class="close" data-dismiss="modal"
                                                                            aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <p><b>{{ __('admin.title') }}:</b>
                                                                                    <span>{{ $estate->title }}</span>
                                                                                </p>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <p><b>{{ __('admin.price') }}:</b>
                                                                                    <span>{{ $estate->min }} $ -
                                                                                        {{ $estate->max }} $</span>
                                                                                </p>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <p><b>{{ __('admin.type') }}:</b>
                                                                                    <span>{{ $estate->type }}</span>
                                                                                </p>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <p><b>{{ __('admin.city') }}:</b>
                                                                                    <span>{{ $estate->city->name }}</span>
                                                                                </p>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <p class="">
                                                                                    <b>{{ __('admin.town') }}:</b>
                                                                                    <span>{{ $estate->town->name }}</span>
                                                                                </p>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <p><b>{{ __('admin.image') }}:</b></p>
                                                                                <div id="estate{{ $key + 1 }}"
                                                                                    class="carousel slide"
                                                                                    data-ride="carousel">
                                                                                    <div class="carousel-inner">
                                                                                        {{-- @isset($estate->image)
                                                                                            @foreach (json_decode($estate->image) as $i => $image)
                                                                                                <div
                                                                                                    class="carousel-item @if ($i == 0) active @endif">
                                                                                                    <img class="d-block w-100"
                                                                                                        src="{{ asset('/storage/' . $image) }}"
                                                                                                        alt="">
                                                                                                </div>
                                                                                            @endforeach
                                                                                        @endisset --}}
                                                                                    </div>
                                                                                    <a class="carousel-control-prev"
                                                                                        href="#estate{{ $key + 1 }}"
                                                                                        data-slide="prev" role="button">
                                                                                        <span
                                                                                            class="carousel-control-prev-icon"
                                                                                            aria-hidden="true"></span>
                                                                                        <span
                                                                                            class="sr-only">Previous</span>
                                                                                    </a>
                                                                                    <a class="carousel-control-next"
                                                                                        href="#estate{{ $key + 1 }}"
                                                                                        data-slide="next" role="button">
                                                                                        <span
                                                                                            class="carousel-control-next-icon"
                                                                                            aria-hidden="true"></span>
                                                                                        <span class="sr-only">Next</span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12 mt-4">
                                                                                <p><b>{{ __('admin.content') }}:</b>
                                                                                    <span>{!! $estate->content !!}</span>
                                                                                </p>
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

                @foreach ($types as $type)
                    <div class="tab-pane fade" id="estate-{{ $type }}" role="tabpanel"
                        aria-labelledby="estate-{{ $type }}-tab">
                        <div class="app-card app-card-orders-table mb-5">
                            <div class="app-card-body">
                                <div class="table-responsive">

                                    <table class="table mb-0 text-left">
                                        <thead>
                                            <tr>
                                                <th class="cell">{{ __('admin.id') }}</th>
                                                <th class="cell">{{ __('admin.title') }}</th>
                                                <th class="cell">{{ __('admin.type') }}</th>
                                                <th class="cell">{{ __('admin.min') }}</th>
                                                <th class="cell">{{ __('admin.max') }}</th>
                                                <th class="cell">{{ __('admin.image') }}</th>
                                                <th class="cell">{{ __('admin.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($estates as $key => $estate)
                                                @if ($estate->type == $type)
                                                    <tr>
                                                        <td class="cell">#{{ $estate->id }}</td>
                                                        <td class="cell"><span
                                                                class="truncate">{{ $estate->title }}</span></td>
                                                        <td class="cell">{{ $estate->type }}</td>
                                                        <td class="cell">{{ $estate->min }} $</td>
                                                        <td class="cell">{{ $estate->max }} $</td>
                                                        <td class="cell images">
                                                            {{-- @foreach (json_decode($estate->image) as $image)
                                                                <img src="{{ asset('/storage/' . $image) }}"
                                                                    alt="">
                                                            @endforeach --}}
                                                        </td>
                                                        <td class="cell">
                                                            <span class="float-right">
                                                                <form method="post"
                                                                    action="{{ route('estates.destroy', $estate->id) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="delete-btn btn-sm app-btn-secondary"
                                                                        data-toggle="tooltip"
                                                                        title="{{ __('admin.delete') }}">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    </button>
                                                                </form>
                                                            </span>
                                                            <span class="float-right mr-1">
                                                                <form method="get"
                                                                    action="{{ route('estates.edit', $estate) }}">
                                                                    @csrf
                                                                    <button class="btn-sm app-btn-secondary edit-btn"
                                                                        data-toggle="tooltip"
                                                                        title="{{ __('admin.edit') }}">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                </form>
                                                            </span>
                                                            <span class="float-right mr-1">
                                                                <a class="btn-sm app-btn-secondary  show-btn"
                                                                    href="#show{{ $key + 1 }}" data-toggle="modal"
                                                                    title="{{ __('admin.preview') }}">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                                <div id="show{{ $key + 1 }}"
                                                                    class="modal fade md-estate" tabindex="-1"
                                                                    role="dialog" aria-labelledby="my-modal-title"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="my-modal-title">
                                                                                    {{ __('admin.estate') }}
                                                                                    #{{ $key + 1 }}</h5>
                                                                                <button class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <p><b>{{ __('admin.title') }}:</b>
                                                                                            <span>{{ $estate->title }}</span>
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <p><b>{{ __('admin.price') }}:</b>
                                                                                            <span>{{ $estate->min }} $ -
                                                                                                {{ $estate->max }}
                                                                                                $</span>
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <p><b>{{ __('admin.type') }}:</b>
                                                                                            <span>{{ $types[$estate->type] }}</span>
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <p><b>{{ __('admin.image') }}:</b>
                                                                                        </p>
                                                                                        <div id="estate{{ $key + 1 }}"
                                                                                            class="carousel slide"
                                                                                            data-ride="carousel">
                                                                                            <div class="carousel-inner">
                                                                                                {{-- @isset($estate->image)
                                                                                                    @foreach (json_decode($estate->image) as $i => $image)
                                                                                                        <div
                                                                                                            class="carousel-item @if ($i == 0) active @endif">
                                                                                                            <img class="d-block w-100"
                                                                                                                src="{{ asset('/storage/' . $image) }}"
                                                                                                                alt="">
                                                                                                        </div>
                                                                                                    @endforeach
                                                                                                @endisset --}}
                                                                                            </div>
                                                                                            <a class="carousel-control-prev"
                                                                                                href="#estate{{ $key + 1 }}"
                                                                                                data-slide="prev"
                                                                                                role="button">
                                                                                                <span
                                                                                                    class="carousel-control-prev-icon"
                                                                                                    aria-hidden="true"></span>
                                                                                                <span
                                                                                                    class="sr-only">Previous</span>
                                                                                            </a>
                                                                                            <a class="carousel-control-next"
                                                                                                href="#estate{{ $key + 1 }}"
                                                                                                data-slide="next"
                                                                                                role="button">
                                                                                                <span
                                                                                                    class="carousel-control-next-icon"
                                                                                                    aria-hidden="true"></span>
                                                                                                <span
                                                                                                    class="sr-only">Next</span>
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12 mt-4">
                                                                                        <p><b>{{ __('admin.content') }}:</b>
                                                                                            <span>{!! $estate->content !!}</span>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                        </tbody>
                                    </table>

                                </div><!--//table-responsive-->
                            </div><!--//app-card-body-->
                        </div><!--//app-card-->
                    </div><!--//tab-pane-->
                @endforeach

            </div>

        </div>
    </div>

@endsection
