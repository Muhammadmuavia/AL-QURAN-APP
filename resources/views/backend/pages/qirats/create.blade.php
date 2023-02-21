
@extends('backend.layouts.master')

@section('title')
Admin Create - Admin Panel
@endsection

@section('styles')
    <style>
        .form-check-label {
            text-transform: capitalize;
        }
        select.form-control:not([size]):not([multiple]) {
            height: calc(2.25rem + 2px);
        }

    </style>
@endsection


@section('admin-content')
<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Add Qirat</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.qirats.index') }}">All Qirats</a></li>
                    <li><span>Add Qirat</span></li>
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
                    <h4 class="header-title">Add New Qirat</h4>
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.qirats.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" id="ayat_id" name="ayat_id" value="{{$_GET['ayat_id']}}" required="">
                        <!-- <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="ayat_id">Ayat Id</label>
                                <input type="text" class="form-control" id="ayat_id" name="ayat_id" placeholder="Enter Ayat Id" required="">
                            </div>
                        </div> -->
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="qari_name">Qari Name</label>
                                <input type="text" class="form-control" id="qari_name" name="qari_name" placeholder="Enter Qari Name" required="">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="qari_audio">Qari Audio</label>
                                <input type="file" class="form-control" id="qari_audio" name="qari_audio" placeholder="Enter Qirat Audio " required="">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Add Qirat</button>
                    </form>

                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
</div>
@endsection

@section('scripts')
    <!-- <script>
        $(document).ready(function() {
            $('.select2').select2();
        })
    </script> -->

@endsection