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
                            <h2 class="content-header-title float-start mb-0">Venues</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Venues </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <section class="bs-validation">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Add Venue</h4>
                                </div>
                                <div class="card-body">
                                    <form id="venue_form" name="venue_form" class="venue_form" action="javascript:;" method="post" novalidate="novalidate">
                                        <div class="mb-1">
                                            <label class="form-label" for="name">Venue Name<span class="text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control" placeholder="Venue Name" required="" title="Enter Venue Name" name="name">
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="address">Venue Address<span class="text-danger">*</span></label>
                                            <textarea name="address" id="address" class="form-control" placeholder="Venue Address" title="Enter Venue Address"></textarea>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="contact">Venue Contact No<span class="text-danger">*</span></label>
                                            <input type="text" id="contact" class="form-control numbers" placeholder="Venue Contact No" required="" title="Enter Venue Contact No" name="contact">
                                        </div>
                                        <button type="button" class="btn btn-warning waves-effect waves-float waves-light submit_btn" onclick="add_venue()">
                                            <span class="spinner-border spinner-border-sm loader" style="display:none" role="status" aria-hidden="true"></span> Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Venue List</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>Sr No</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Contact</th>
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
                </section>
            </div>
        </div>
    </div>
    <div class="modal fade text-start" id="edit_venue_modal" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" data-bs-backdrop="show" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Venue </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="javascript:;" class="edit_venue_form" name="edit_venue_form" id="edit_venue_form">
                    <div class="modal-body">
                        <div class="mb-1">
                            <label class="form-label" for="name">Venue Name<span class="text-danger">*</span></label>
                            <input type="text" id="edit_name" class="form-control" placeholder="Name" required="" title="Enter name" name="edit_name">
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="edit_address">Venue Address<span class="text-danger">*</span></label>
                            <textarea name="edit_address" id="edit_address" class="form-control" placeholder="Venue Address" title="Enter Venue Address"></textarea>
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="edit_contact">Venue Contact No<span class="text-danger">*</span></label>
                            <input type="text" id="edit_contact" class="form-control numbers" placeholder="Venue Contact No" required="" title="Enter Venue Contact No" name="edit_contact">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning waves-effect waves-float waves-light edit_submit_btn" onclick="update_venue()">
                            <span class="spinner-border spinner-border-sm loader" style="display:none" role="status" aria-hidden="true"></span> Update</button>
                    </div>
                    <input type="hidden" name="edit_id" id="edit_id" />
                </form>
            </div>
        </div>
    </div>
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
</body>
@include('elements.bottom-js')
<script src="{{ asset('js/backend/venue.js') }}"></script>