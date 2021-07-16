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
                    <form class="mt-4" action="{{ route('product.update', $product->product_code) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formProduk">Kode Produk</label><span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="formProduk" name="product_code" placeholder="ex : P0001" value="{{ old('product_code', $product->product_code) }}" readonly>
                                    @error('product_code')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formNama">Nama Produk</label><span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="formNama" name="product_name" placeholder="ex : Sayur Bayam" value="{{ old('product_name', $product->name) }}">
                                    @error('product_name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col">
                                <div class="form-group">
                                    <label for="formNama">Nama Produk</label><span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="formNama" name="product_name" placeholder="ex : Sayur Bayam" value="{{ old('product_name', $product->name) }}">
                                    @error('product_name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="col">
                                <div class="form-group">
                                    <label for="formCover">Sampul</label>
                                    <input type="file" name="cover" id="formCover" class="form-control">
                                    @if ($product->cover != null)
                                    <a style="cursor: pointer;" data-toggle="modal" class="showDetailData" data-target=".modal-show-detail" data-image="{{ url(''.$product->cover) }}">
                                        <img src="{{ url(''.$product->cover) }}" class="rounded mt-2 mb-2" alt="{{ $product->name }}" width="100" height="100">
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="formStock">Stok(biji)</label><span class="text-danger">*</span>
                                    <input type="number" class="form-control" id="formStock" name="stock" placeholder="ex : 20" value="{{ old('stock', $product->stock) }}">
                                    @error('stock')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="formSupplier">Suplier</label><span class="text-danger">*</span>
                                    <select name="supplier_code" id="formSupplier" class="form-control">
                                        <option value="">Pilih Suplier</option>
                                        @foreach ($supplier_code as $item)
                                            <option value="{{ $item->supplier_code }}" {{ $item->supplier_code == $product->supplier_code ? 'selected' : '' }}>{{ $item->supplier_code }} - {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_code')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="formStock">Stok(kg)</label><span class="text-danger">*</span>
                                    <input type="number" class="form-control" id="formStock" name="stock" placeholder="ex : 20" value="{{ old('stock', $product->stock) }}">
                                    @error('stock')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="formPrice">Harga Beli</label><span class="text-danger">*</span>
                                    <input type="number" class="form-control" id="formPrice" name="price" placeholder="ex : 3,000.00" value="{{ old('price', $product->price) }}">
                                    @error('price')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="formSellPrice">Harga Jual</label><span class="text-danger">*</span>
                                    <input type="number" class="form-control" id="formSellPrice" name="sell_price" placeholder="ex : 7,000.00" value="{{ old('sell_price', $product->sell_price) }}">
                                    @error('sell_price')
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