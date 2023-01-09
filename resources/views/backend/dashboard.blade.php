@extends('layouts.default')
@section('content')
@include('elements.top-css')

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">
    @include('elements.header')
    @include('elements.sidebar')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card card-congratulations">
                    <div class="card-body text-center">
                        <img src="{{asset('backend/images/decore-left.png')}}" class="congratulations-img-left" alt="card-img-left">
                        <img src="{{asset('backend/images/decore-right.png')}}" class="congratulations-img-right" alt="card-img-right">
                        <div class="avatar avatar-xl bg-primary shadow">
                            <div class="avatar-content">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award font-large-1">
                                    <circle cx="12" cy="8" r="7"></circle>
                                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                </svg>
                            </div>
                        </div>
                        <div class="text-center">
                            <h1 class="mb-1 text-white">Congratulations {{Illuminate\Support\Facades\Auth::user()->name}}</h1>
                            <p class="card-text m-auto w-75">
                                You have login successfully!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Event List</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline" id="datatable">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Title</th>
                                    <th>Artist</th>
                                    <th>Genre</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Venue</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-start" id="edit_event_modal" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" data-bs-backdrop="show" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Event </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="javascript:;" class="edit_event_form" name="edit_event_form" id="edit_event_form">
                    <div class="modal-body">
                        <div class="col-md-12 col-12">
                            <div class="row">
                                @php
                                $venue = App\Models\Venue::where('status', '=', '0')->get();
                                $artist = App\Models\Artist::where('status', '=', '0')->get();
                                $genre = App\Models\Genre::where('status', '=', '0')->get();
                                @endphp
                                <div class="col-md-6 col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="edit_title">Title<span class="text-danger">*</span></label>
                                        <input type="text" id="edit_title" class="form-control alpha" placeholder="Title" required="" title="Enter Title" name="edit_title">
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="edit_artist_id">Artist<span class="text-danger">*</span></label>
                                        <select class="select2 form-select edit_artist_id" id="edit_artist_id" name="edit_artist_id" title="Select Artist">
                                            <option value="" selected disabled>Select Artist</option>
                                            @foreach($artist as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label id="edit_artist_id-error" class="error" for="edit_artist_id"></label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="edit_genre_id">Genre<span class="text-danger">*</span></label>
                                        <select class="select2 form-select edit_genre_id" id="edit_genre_id" name="edit_genre_id" title="Select Genre">
                                            <option value="" selected disabled>Select Genre</option>
                                            @foreach($genre as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label id="edit_genre_id-error" class="error" for="edit_genre_id"></label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="edit_amount">Amount<span class="text-danger">*</span></label>
                                        <input type="text" id="edit_amount" class="form-control numbers" placeholder="Amount" required="" title="Enter Amount" name="edit_amount">
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="edit_image">Image<span class="text-danger">*</span></label>
                                        <input type="file" id="edit_image" class="form-control" title="Select Image" name="edit_image" onChange="editImageEvent(this)">
                                    </div>
                                    <div class="mb-1">
                                        <div class="mb-1">
                                            <img src="" style="display:none" class="edit_image_view" id="edit_image_view" width="120" height="80">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="edit_short_description">Short Description<span class="text-danger">*</span></label>
                                        <textarea name="edit_short_description" id="edit_short_description" class="form-control" placeholder="Short Description" title="Enter Short Description"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="edit_date">Date<span class="text-danger">*</span></label>
                                        <input type="text" id="edit_date" name="edit_date" class="form-control flatpickr-basic" placeholder="DD-MM-YYYY" readonly="readonly" title="Select Date">
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="edit_venue_id">Venue<span class="text-danger">*</span></label>
                                        <select class="select2 form-select edit_venue_id" id="edit_venue_id" name="edit_venue_id" title="Select Venue">
                                            <option value="" selected disabled>Select Venue</option>
                                            @foreach($venue as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label id="edit_venue_id-error" class="error" for="edit_venue_id"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning waves-effect waves-float waves-light edit_submit_btn" onclick="update_event()">
                            <span class="spinner-border spinner-border-sm loader" style="display:none" role="status" aria-hidden="true"></span> Update</button>
                    </div>
                    <input type="hidden" name="edit_id" id="edit_id" />
                    <input type="hidden" name="edit_image_name" id="edit_image_name" value="" />
                </form>
            </div>
        </div>
    </div>
</body>
@include('elements.bottom-js')
<script src="{{ asset('js/backend/event.js') }}"></script>