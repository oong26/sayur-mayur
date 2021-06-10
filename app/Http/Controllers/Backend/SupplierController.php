<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    private $param;
    public function __construct()
    {
        $this->param['title'] = 'Suplier';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->param['subtitle'] = 'List Suplier';
        $this->param['data'] = Supplier::all();
        $this->param['top_button'] = route('supplier.create');

        return view('backend.supplier.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['subtitle'] = 'Tambah Suplier';
        $this->param['top_button'] = route('supplier.index');
        $supplierCode = null;
        $supplier = Supplier::orderBy('supplier_code', 'DESC')->get();
    
        if($supplier->count() > 0){
            $supplierCode = $supplier[0]->supplier_code;

            $lastIncreament = substr($supplierCode, 2);

            $supplierCode = str_pad($lastIncreament + 1, 3, 0, STR_PAD_LEFT);
            $supplierCode = 'SC'.$supplierCode;
            
        }
        else{
            $supplierCode = "SC001";
        }
        $this->param['supplier_code'] = $supplierCode;

        return view('backend.supplier.create', $this->param);
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
                'supplier_code' => 'required',
                'nama_lengkap' => 'required|min:6|max:50',
                'address' => 'required|min:8',
                'phone' => 'required|min:11|max:13|unique:supplier,phone'
            ],
            [
                'required' => ':attribute harus diisi.',
                'nama_lengkap.min' => 'Minimal panjang karakter 6.',
                'nama_lengkap.max' => 'Maksimal panjang karakter 50.',
                'address.min' => 'Harap masukkan dengan benar.',
                'phone.min' => 'Minimal panjang karakter 11',
                'phone.max' => 'Maksimal panjang karakter 13',
                'phone.unique' => ':attribute telah terdaftar.'
            ],
            [
                'supplier_code' => 'Kode Suplier',
                'nama_lengkap' => 'Nama lengkap',
                'address' => 'Alamat',
                'phone' => 'Nomor hp'
            ]
        );

        try{
            $newSupplier = new Supplier;
            $newSupplier->supplier_code = $request->get('supplier_code');
            $newSupplier->name = $request->get('nama_lengkap');
            $newSupplier->address = $request->get('address');
            $newSupplier->phone = $request->get('phone');
            
            $newSupplier->save();
            return redirect('master/supplier')->withStatus('Berhasil menambah data.');
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
    public function edit($supplierCode)
    {
        try{
            $this->param['subtitle'] = 'Edit';
            $this->param['top_button'] = route('supplier.index');
            $this->param['supplier'] = Supplier::where('supplier_code', $supplierCode)->first();
            
            return view('backend.supplier.edit', $this->param);
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
    public function update(Request $request, $supplierCode)
    {
        try{
            $supplier = Supplier::where('supplier_code', $supplierCode)->first();

            $isUnique = $supplier->phone == $request->get('phone') ? '' : '|unique:supplier,phone';
            $this->validate($request, 
                [
                    'supplier_code' => 'required',
                    'nama_lengkap' => 'required|min:6|max:50',
                    'address' => 'required|min:8',
                    'phone' => 'required|min:11|max:13|'.$isUnique
                ],
                [
                    'required' => ':attribute harus diisi.',
                    'nama_lengkap.min' => 'Minimal panjang karakter 6.',
                    'nama_lengkap.max' => 'Maksimal panjang karakter 50.',
                    'address.min' => 'Harap masukkan dengan benar.',
                    'phone.min' => 'Minimal panjang karakter 11',
                    'phone.max' => 'Maksimal panjang karakter 13',
                    'phone.unique' => ':attribute telah terdaftar.'
                ],
                [
                    'supplier_code' => 'Kode Suplier',
                    'nama_lengkap' => 'Nama lengkap',
                    'gender' => 'Jenis kelamin',
                    'phone' => 'Nomor hp'
                ]
            );
            DB::table('supplier')->where('supplier_code', $supplierCode)->update([
                "supplier_code" => $request->get('supplier_code'),
                "name" => $request->get('nama_lengkap'),
                "address" => $request->get('address'),
                "phone" => $request->get('phone')
            ]);

            return redirect('master/supplier')->withStatus('Berhasil menyimpan data.');
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
    public function destroy($supplierCode)
    {
        try{
            DB::delete('delete from supplier where supplier_code = ?', [$supplierCode]);
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
