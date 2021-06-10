<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Courrier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourrierController extends Controller
{
    private $param;
    public function __construct()
    {
        $this->param['title'] = 'Kurir';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->param['subtitle'] = 'List Kurir';
        $this->param['data'] = Courrier::all();
        $this->param['top_button'] = route('courrier.create');

        return view('backend.courrier.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['subtitle'] = 'Tambah Kurir';
        $this->param['top_button'] = route('courrier.index');
        $courrierCode = null;
        $courrier = Courrier::orderBy('courrier_code', 'DESC')->get();
        
        if($courrier->count() > 0){
            $courrierCode = $courrier[0]->courrier_code;

            $lastIncrement = substr($courrierCode, 2);

            $courrierCode = str_pad($lastIncrement + 1, 3, 0, STR_PAD_LEFT);
            $courrierCode = 'CC'.$courrierCode;
            
        }
        else{
            $courrierCode = "CC001";
        }
        $this->param['courrier_code'] = $courrierCode;

        return view('backend.courrier.create', $this->param);
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
                'courrier_code' => 'required',
                'nama_lengkap' => 'required|min:6|max:50',
                'gender' => 'required',
                'phone' => 'required|min:11|max:13|unique:courrier,phone'
            ],
            [
                'required' => ':attribute harus diisi.',
                'nama_lengkap.min' => 'Minimal panjang karakter 6.',
                'nama_lengkap.max' => 'Maksimal panjang karakter 50.',
                'phone.min' => 'Minimal panjang karakter 11',
                'phone.max' => 'Maksimal panjang karakter 13',
                'phone.unique' => ':attribute telah terdaftar.'
            ],
            [
                'courrier_code' => 'Kode Kurir',
                'nama_lengkap' => 'Nama lengkap',
                'gender' => 'Jenis kelamin',
                'phone' => 'Nomor hp'
            ]
        );

        try{
            $newCourrier = new Courrier;
            $newCourrier->courrier_code = $request->get('courrier_code');
            $newCourrier->name = $request->get('nama_lengkap');
            $newCourrier->gender = $request->get('gender');
            $newCourrier->phone = $request->get('phone');
            
            $newCourrier->save();
            return redirect('master/courrier')->withStatus('Berhasil menambah data.');
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
    public function edit($courrierCode)
    {
        try{
            $this->param['subtitle'] = 'Edit';
            $this->param['top_button'] = route('courrier.index');
            $this->param['courrier'] = Courrier::where('courrier_code', $courrierCode)->first();
            
            return view('backend.courrier.edit', $this->param);
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
    public function update(Request $request, $courrierCode)
    {
        try{
            $courrier = Courrier::where('courrier_code', $courrierCode)->first();

            $isUnique = $courrier->phone == $request->get('phone') ? '' : '|unique:courrier,phone';
            $this->validate($request, 
                [
                    'courrier_code' => 'required',
                    'nama_lengkap' => 'required|min:6|max:50',
                    'gender' => 'required',
                    'phone' => 'required|min:11|max:13|'.$isUnique
                ],
                [
                    'required' => ':attribute harus diisi.',
                    'nama_lengkap.min' => 'Minimal panjang karakter 6.',
                    'nama_lengkap.max' => 'Maksimal panjang karakter 50.',
                    'phone.min' => 'Minimal panjang karakter 11',
                    'phone.max' => 'Maksimal panjang karakter 13',
                    'phone.unique' => ':attribute telah terdaftar.'
                ],
                [
                    'courrier_code' => 'Kode Kurir',
                    'nama_lengkap' => 'Nama lengkap',
                    'gender' => 'Jenis kelamin',
                    'phone' => 'Nomor hp'
                ]
            );
            DB::table('courrier')->where('courrier_code', $courrierCode)->update([
                "courrier_code" => $request->get('courrier_code'),
                "name" => $request->get('nama_lengkap'),
                "gender" => $request->get('gender'),
                "phone" => $request->get('phone')
            ]);

            return redirect('master/courrier')->withStatus('Berhasil menyimpan data.');
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
    public function destroy($courrierCode)
    {
        try{
            DB::delete('delete from courrier where courrier_code = ?', [$courrierCode]);
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
