@extends('admin.layouts.app')

@section('pageTitle',__('admin.contacts'))

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
              <h1 class="app-page-title mb-0">{{ __('admin.all_contacts') }}</h1>
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
                      <th class="cell">{{ __('admin.phone') }}</th>
                      <th class="cell">{{ __('admin.date') }}</th>
                      <th class="cell">{{ __('admin.actions') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($contacts as $key => $contact)
                      <tr>
                        <td class="cell">{{ $key+1 }}</td>
                        <td class="cell">{{ $contact->name }}</td>
                        <td class="cell">{{ $contact->email }}</td>
                        <td class="cell">{{ $contact->phone }}</td>
                        <td class="cell">{{ $contact->created_at->format('d/m/Y') }}</td>
                        <td class="cell">
                          <span class="float-right">
                            <form method="post" action="{{ route('contacts.destroy',$contact->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="delete-btn btn-sm app-btn-secondary" data-toggle="tooltip" title="{{ __('admin.delete') }}">
                                  <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                          </span>
                          <span class="float-right mr-1">
                            <a class="btn-sm app-btn-secondary show-btn" href="#show{{ $key+1 }}" data-toggle="modal" title="{{ __('admin.preview') }}">
                              <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                            <div id="show{{ $key+1 }}" class="modal fade md-estate md-contact" tabindex="-1" role="dialog aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="my-modal-title">{{ __('admin.contact') }} #{{ $key+1 }}</h5>
                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="row">
                                      <div class="col-md-6">
                                        <p><b>{{ __('admin.name') }}:</b> <span>{{ $contact->name }}</span></p>
                                      </div>
                                      <div class="col-md-6">
                                        <p><b>{{ __('admin.email') }}:</b> <span>{{ $contact->email }}</span></p>
                                      </div>
                                      <div class="col-md-6">
                                        <p><b>{{ __('admin.phone') }}:</b> <span>{{ $contact->phone }}</span></p>
                                      </div>
                                      <div class="col-md-6">
                                        <p><b>{{ __('admin.date') }}:</b> <span>{{ $contact->created_at->format('d/m/Y') }}</span></p>
                                      </div>
                                      <div class="col-md-12 mt-4">
                                        <p><b>{{ __('admin.message') }}:</b> <div>{{ $contact->message }}</div></p>
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

