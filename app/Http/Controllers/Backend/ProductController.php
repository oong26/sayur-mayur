<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;

class ProductController extends Controller
{
    private $param;
    public function __construct()
    {
        $this->param['title'] = 'Produk';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->param['subtitle'] = 'List Produk';
        $this->param['data'] = Products::orderBy('products.product_code', 'ASC')
                                        ->get();
        // $this->param['data'] = Products::select('products.*', 'supplier.name AS supplier_name')
        //                                 ->join('supplier', 'supplier.supplier_code', 'products.supplier_code')
        //                                 ->orderBy('products.product_code', 'ASC')
        //                                 ->get();
        $this->param['top_button'] = route('product.create');

        return view('backend.product.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['subtitle'] = 'Tambah Produk';
        $this->param['top_button'] = route('product.index');
        $productCode = null;
        $courrier = Products::orderBy('product_code', 'DESC')->get();
        
        if($courrier->count() > 0){
            $productCode = $courrier[0]->product_code;

            $lastIncrement = substr($productCode, 1);

            $productCode = str_pad($lastIncrement + 1, 4, 0, STR_PAD_LEFT);
            $productCode = 'P'.$productCode;
            
        }
        else{
            $productCode = "P0001";
        }
        $this->param['product_code'] = $productCode;
        // $this->param['supplier_code'] = Supplier::orderBy('supplier_code', 'ASC')->get();

        return view('backend.product.create', $this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, 
            [
                'product_code' => 'required',
                'product_name' => 'required|min:3|max:50|unique:products,name',
                'cover' => 'required',
                // 'supplier_code' => 'required',
                'stock' => 'required',
                'price' => 'required',
                'sell_price' => 'required'
            ],
            [
                'required' => ':attribute harus diisi.',
                'product_name.min' => 'Minimal panjang karakter 3.',
                'product_name.max' => 'Maksimal panjang karakter 50.',
                'unique' => ':attribute telah terdaftar.'
            ],
            [
                'product_code' => 'Kode produk',
                'product_name' => 'Nama produk',
                'cover' => 'Foto Sampul',
                // 'supplier_code' => 'Suplier',
                'stock' => 'Stok',
                'price' => 'Harga beli',
                'sell_price' => 'Harga jual'
            ]
        );

        try{
            if($request->file('cover') != null) {
                $folder = 'upload/product/'.$request->get('product_code');
                $file = $request->file('cover');
                $filename = date('YmdHis').$file->getClientOriginalName();
                // Get canonicalized absolute pathname
                $path = realpath($folder);

                // If it exist, check if it's a directory
                if(!($path !== true AND is_dir($path)))
                {
                    // Path/folder does not exist then create a new folder
                    mkdir($folder, 0755, true);
                }
                if($file->move($folder, $filename)) {
                    DB::table('products')->insert([
                        'product_code' => $request->get('product_code'),
                        'name' => $request->get('product_name'),
                        // 'supplier_code' => $request->get('supplier_code'),
                        'cover' => $folder.'/'.$filename,
                        'stock' => $request->get('stock'),
                        'price' => $request->get('price'),
                        'sell_price' => $request->get('sell_price')
                    ]);
                }
            }

            return redirect('master/product')->withStatus('Berhasil menambah data.');
        }
        catch(\Exception $e){
            return redirect()->back()->withError($e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($productCode)
    {
        try{
            $this->param['subtitle'] = 'Edit';
            $this->param['top_button'] = route('product.index');
            $this->param['product'] = Products::where('product_code', $productCode)->first();
            // $this->param['supplier_code'] = Supplier::orderBy('supplier_code', 'ASC')->get();
            
            return view('backend.product.edit', $this->param);
        }
        catch(\Exception $e){
            return redirect()->back()->withError($e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $productCode)
    {
        try{
            $product = Products::where('product_code', $productCode)->first();

            $isUnique = $product->name == $request->product_name ? '' : '|unique:product,product_name';
            $cover = $product->cover;

            $this->validate($request, 
                [
                    'product_code' => 'required',
                    'product_name' => 'required|min:3|max:50'.$isUnique,
                    // 'supplier_code' => 'required',
                    'stock' => 'required',
                    'price' => 'required',
                    'sell_price' => 'required'
                ],
                [
                    'required' => ':attribute harus diisi.',
                    'product_name.min' => 'Minimal panjang karakter 3.',
                    'product_name.max' => 'Maksimal panjang karakter 50.',
                    'unique' => ':attribute telah terdaftar.'
                ],
                [
                    'product_code' => 'Kode produk',
                    'product_name' => 'Nama produk',
                    // 'supplier_code' => 'Suplier',
                    'stock' => 'Stok',
                    'price' => 'Harga beli',
                    'sell_price' => 'Harga jual'
                ]
            );

            if($request->file('cover') != null) {
                $folder = 'upload/product/'.$request->get('product_code');
                $file = $request->file('cover');
                $filename = date('YmdHis').$file->getClientOriginalName();
                // Get canonicalized absolute pathname
                $path = realpath($folder);

                // If it exist, check if it's a directory
                if(!($path !== true AND is_dir($path)))
                {
                    // Path/folder does not exist then create a new folder
                    mkdir($folder, 0755, true);
                }
                if($cover != null){
                    if(file_exists($cover)){
                        if(File::delete($cover)){
                            if($file->move($folder, $filename)) {
                                DB::table('products')->where('product_code', $productCode)->update([
                                    'product_code' => $request->get('product_code'),
                                    'name' => $request->get('product_name'),
                                    // 'supplier_code' => $request->get('supplier_code'),
                                    'cover' => $folder.'/'.$filename,
                                    'stock' => $request->get('stock'),
                                    'price' => $request->get('price'),
                                    'sell_price' => $request->get('sell_price'),
                                    'updated_at' => time()
                                ]);
                            }
                        }
                    }
                }
            }
            else {
                DB::table('products')->where('product_code', $productCode)->update([
                    'product_code' => $request->get('product_code'),
                    'name' => $request->get('product_name'),
                    // 'supplier_code' => $request->get('supplier_code'),
                    'stock' => $request->get('stock'),
                    'price' => $request->get('price'),
                    'sell_price' => $request->get('sell_price'),
                    'updated_at' => time()
                ]);
            }

            return redirect('master/product')->withStatus('Berhasil menyimpan perubahan.');
        }
        catch(\Exception $e){
            return redirect()->back()->withError($e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($productCode)
    {
        try{
            $product = Products::where('product_code', $productCode)->first();

            $cover = $product->cover;
            if($cover != null){
                if(file_exists($cover)){
                    if(File::delete($cover)){
                        Products::where('product_code', $productCode)->delete();
                    }
                }
            }
            return redirect()->back()->withStatus('Berhasil menghapus data.');
        }
        catch(\Exception $e){
            return redirect()->back()->withError($e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
