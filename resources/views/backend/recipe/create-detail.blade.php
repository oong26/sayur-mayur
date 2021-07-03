<table class="table table-bordered">
    <thead>
        <tr>
            <td>Bahan-bahan</td>
            <td>Takaran</td>
            <td>Aksi</td>
        </tr>
    </thead>
    <tbody>
        <tr id="field1">
            <input type="hidden" id="count" value="1" />
            <td>
                <select name="product_code[]" id="product_code[]" class="form-control">
                    <option value="">Pilih bahan</option>
                    @foreach ($product as $product_item)
                        <option value="{{ $product_item->product_code }}">{{ $product_item->product_code }} - {{ $product_item->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="dose[]" id="dose[]" class="form-control" placeholder="Masukkan takaran disini">
            </td>
            <td>
                <button type="button" class="btn btn-danger ml-4 btn-delete-field" id="btn-delete-field1" style="display: none;"><span class="fa fa-minus"></span></button>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"></td>
            <td class="text-center">
                <button type="button" class="btn btn-primary btn-add-more1" id="btn_add_item">Tambah</button>
            </td>
        </tr>
    </tfoot>
</table>

{{-- <div class="row mb-2 field">
    <div class="col">
        <select name="product_code[]" id="product_code[]" class="form-control">
            <option value="">Pilih bahan</option>
            @foreach ($product as $product_item)
                <option value="{{ $product_item->product_code }}">{{ $product_item->product_code }} - {{ $product_item->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col">
        <input autocomplete="off" class="input form-control" id="field1" name="prof1" type="text" placeholder="Type something" data-items="8"/>
    </div>
    <div class="col">
        <button id="b1" class="btn add-more" type="button">+</button>
    </div>
</div> --}}