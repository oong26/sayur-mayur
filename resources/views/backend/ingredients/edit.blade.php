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
                    <h3 class="box-title">{{ $subtitle }}</h3>
                    <a href="{{ $top_button }}" class="btn btn-primary text-white">
                        Lihat Data
                    </a>
                    <form class="mt-4" action="{{ route('ingredients.update', $ingredient->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formResep">Resep</label><span class="text-danger">*</span>
                                    <select class="form-control" name="recipe_code" id="formResep">
                                        <option value="0">Pilih Resep</option>
                                        @foreach ($recipe as $item)
                                            <option value="{{ $item->recipe_code }}" @if(old('recipe_code', $ingredient->recipe_code) == $item->recipe_code) selected @endif>{{ ucwords($item->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('recipe_code')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formProduct">Bahan</label><span class="text-danger">*</span>
                                    <select class="form-control" name="product_code" id="formProduct">
                                        <option value="0">Pilih Bahan</option>
                                        @foreach ($product as $item)
                                            <option value="{{ $item->product_code }}" @if(old('product_code', $ingredient->product_code) == $item->product_code) selected @endif>{{ ucwords($item->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_code')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formDose">Takaran</label><span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="formNama" name="dose" placeholder="ex : 1 buah" value="{{ old('dose', $ingredient->dose) }}">
                                    @error('dose')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-inline">
                            <input type="submit" value="Simpan" class="btn btn-success mr-2">
                            <input type="reset" value="Batal" class="btn btn-danger">
                        </div>
                    </form>
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
@endsection