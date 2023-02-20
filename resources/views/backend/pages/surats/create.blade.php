
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
                <h4 class="page-title pull-left">Add Surat</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.surats.index') }}">All Surat</a></li>
                    <li><span>Add Surat</span></li>
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
                    <h4 class="header-title">Add New Surat</h4>
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.surats.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="surat_arabic">Arabic Name</label>
                                <input type="text" class="form-control" id="surat_arabic" name="surat_arabic" placeholder="Enter Arabic Name" required="">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="surat_english">English Name</label>
                                <input type="text" class="form-control" id="surat_english" name="surat_english" placeholder="Enter English Name" required="">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Add Language</button>
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

    <!-- for masking -->
    <script>
        $('input[name="zip_code"]').mask('00000');
    </script>

    <!--search box-->
    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
            });
        });
    </script>
@endsection