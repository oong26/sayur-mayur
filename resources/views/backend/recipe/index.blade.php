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
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Sukses!</strong>&nbsp;{{ session('status') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Terjadi kesalahan!</strong>{{ session('error') }}.
                    </div>
                    @endif
                    <h3 class="box-title">{{ $subtitle }}</h3>
                    <a href="{{ $top_button }}" class="btn btn-primary text-white mb-3">
                        Tambah
                    </a>
                    <table class="table table-xl-responsive mt-4" id="data_table">
                        <thead>
                            <th class="text-center">Kode Resep</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Aksi</th>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td class="text-center pt-4">{{ $item->recipe_code }}</td>
                                <td>
                                    <a style="cursor: pointer;" data-toggle="modal" class="showDetailData" data-target=".modal-show-detail" data-image="{{ url(''.$item->cover) }}">
                                        <img src="{{ url(''.$item->cover) }}" class="rounded mr-4" alt="{{ $item->name }}" width="80" height="80">
                                    </a>
                                    {{ $item->name }}
                                </td>
                                <td class="text-center">{{ $item->stock }}</td>
                                <td class="text-right">Rp{{ number_format($item->price, 2, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="form-inline p-0">
                                            <a href="{{ route('recipe.show', $item->recipe_code) }}" class="btn btn-primary mr-2" title="Edit" data-toggle="tooltip"> <span class="fa fa-eye"></span> </a>
                                            <a href="{{ route('recipe.edit', $item->recipe_code) }}" class="btn btn-success mr-2" title="Edit" data-toggle="tooltip"> <span class="fa fa-pen"></span> </a>
                                            <form action="{{ route('recipe.destroy', $item->recipe_code) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-danger" title="Hapus" data-toggle="tooltip" onclick="confirm('{{ __("Apakah anda yakin ingin menghapus?") }}') ? this.parentElement.submit() : ''">
                                                    <span class="fa fa-minus-circle"></span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>
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