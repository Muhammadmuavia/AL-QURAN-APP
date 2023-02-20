
@extends('backend.layouts.master')

@section('title')
Admin Edit - Admin Panel
@endsection

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//geodata.solutions/includes/countrystatecity.js"></script> 

@section('styles')
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> -->
    <style>
        .form-check-label {
            text-transform: capitalize;
        }
        select.form-control:not([size]):not([multiple]) {
            height: calc(2.5rem + 2px);
        }
    </style>
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Qirat Edit</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.qirats.index') }}">All Qirat</a></li>
                    <li><span>Edit Qirat</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Edit Qirat</h4>
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.qirats.update', $qirat->qari_id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="qari_name">Qari Name</label>
                                <input type="text" class="form-control" id="qari_name" name="qari_name" placeholder="Enter Qari Name" value="{{ $qirat->qari_name }}">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="qari_audio">Qari Audio</label>
                                <input type="text" class="form-control" id="qari_audio" name="qari_audio" placeholder="Enter Qari audio" value="{{ $qirat->qari_audio }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save Qirat</button>
                    </form>

                </div>
            </div>
        </div>
        <!-- data table end -->

    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    })
</script>
@endsection