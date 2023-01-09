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
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Events</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Events </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <section class="bs-validation">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Add Event</h4>
                                </div>
                                <div class="card-body">
                                    <form id="event_form" name="event_form" class="event_form" action="javascript:;" method="post" novalidate="novalidate">
                                        <div class="mb-1">
                                            <label class="form-label" for="title">Title<span class="text-danger">*</span></label>
                                            <input type="text" id="title" class="form-control alpha" placeholder="Title" required="" title="Enter Title" name="title">
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="artist_id">Artist<span class="text-danger">*</span></label>
                                            <select class="select2 form-select artist_id" id="artist_id" name="artist_id" title="Select Artist">
                                                <option value="" selected disabled>Select Artist</option>
                                                @foreach($artist as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label id="artist_id-error" class="error" for="artist_id"></label>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="genre_id">Genre<span class="text-danger">*</span></label>
                                            <select class="select2 form-select genre_id" id="genre_id" name="genre_id" title="Select Genre">
                                                <option value="" selected disabled>Select Genre</option>
                                                @foreach($genre as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label id="genre_id-error" class="error" for="genre_id"></label>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="image">Image<span class="text-danger">*</span></label>
                                                <input type="file" id="image" class="form-control" required="" title="Select Image" name="image" onChange="imageEvent(this)">
                                            </div>
                                            <div class="mb-1">
                                                <div class="mb-1">
                                                    <img src="" style="display:none" class="image_view" id="image_view" width="120" height="80">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="short_description">Short Description<span class="text-danger">*</span></label>
                                            <textarea name="short_description" id="short_description" class="form-control" placeholder="Short Description" title="Enter Short Description"></textarea>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="amount">Amount<span class="text-danger">*</span></label>
                                            <input type="text" id="amount" class="form-control numbers" placeholder="Amount" required="" title="Enter Amount" name="amount">
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="date">Date<span class="text-danger">*</span></label>
                                            <input type="text" id="date" name="date" class="form-control flatpickr-basic" placeholder="DD-MM-YYYY" readonly="readonly" title="Select Date">
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="contact">Venue<span class="text-danger">*</span></label>
                                            <select class="select2 form-select venue_id" id="venue_id" name="venue_id" title="Select Venue">
                                                <option value="" selected disabled>Select Venue</option>
                                                @foreach($venue as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label id="venue_id-error" class="error" for="venue_id"></label>
                                        </div>
                                        <div class="mt-1" style="justify-content: center; display: flex;">
                                            <button type="button" class="btn btn-warning waves-effect waves-float waves-light submit_btn" onclick="add_event()">
                                                <span class="spinner-border spinner-border-sm loader" style="display:none" role="status" aria-hidden="true"></span> Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
</body>
@include('elements.bottom-js')
<script src="{{ asset('js/backend/event.js') }}"></script>