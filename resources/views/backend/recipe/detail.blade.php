@extends('backend.layout.master')
@section('content')
<div class="page-wrapper" style="min-height: 250px;">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">{{ $title }}</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">{{ $title }}/{{ $subtitle }}</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Terjadi kesalahan!</strong>&nbsp;{{ session('error') }}.
                    </div>
                    @endif
                    <a href="{{ $top_button }}" class="btn btn-primary text-white">
                        Lihat Data
                    </a>
                    <h3 class="box-title mt-4">{{ $subtitle }}</h3>
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-md-responsive table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th class="text-left">Nama Resep</th>
                                        <th class="text-center">:</th>
                                        <th class="text-center">{{ $recipe->name }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-left">Banyaknya Bahan</th>
                                        <th class="text-center">:</th>
                                        <th class="text-center">{{ count($recipe_item) }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <h3 class="box-title mt-4">Bahan-bahan</h3>
                    @forelse ($recipe_item as $item)
                    <div class="row p-0">
                        <div class="col-md-8">
                            <div class="card-group m-0 ">
                                <div class="card">
                                    <div class="card-body">
                                    <p class="card-text">Bahan ke-{{ $loop->iteration }}</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-text">{{ $item->product_name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-group">
                                <div class="card">
                                    <div class="card-body">
                                    <p class="card-text">Takaran</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-text">{{ $item->dose }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row pl-3">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col">
                                    <label class="text-left">Bahan ke-{{ $loop->iteration }}</label>
                                </div>
                                <div class="col">
                                    <label class="text-left">Bahan ke-{{ $loop->iteration }}</label>
                                </div>
                                <div class="col">
                                    <label class="text-left">Bahan ke-{{ $loop->iteration }}</label>
                                </div>
                            </div>
                            <table class="table table-md-responsive table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th class="text-left">Bahan ke-{{ $loop->iteration }}</th>
                                        <th class="text-center">:</th>
                                        <th class="text-center">{{ $item->product_name }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-left">Takaran</th>
                                        <th class="text-center">:</th>
                                        <th class="text-center">{{ $item->dose }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div> --}}
                    @empty
                    <h5 class="box-title mt-4 text-muted">Bahan-bahan belum ada.</h5>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <footer class="footer text-center"> 2021 © Ample Admin brought to you by <a
            href="https://www.wrappixel.com/">wrappixel.com</a>
    </footer>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>
<div class="modal modal-show-detail">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          {{-- <h6 class="modal-title">Detail Data</h6> --}}
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body text-center">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <img alt="" id="showDetail" width="100%">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection