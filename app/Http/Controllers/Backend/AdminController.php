<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use File;

class AdminController extends Controller
{
    private $param;
    public function __construct()
    {
        $this->param['title'] = 'Admin';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->param['subtitle'] = 'List Admin';
        $this->param['data'] = User::select('id', 'name', 'username', 'profile_photo')->get();
        $this->param['top_button'] = route('user.create');

        return view('backend.user.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['subtitle'] = 'Tambah Admin';
        $this->param['top_button'] = route('user.index');

        return view('backend.user.create', $this->param);
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
                'nama_lengkap' => 'required|min:6|max:50',
                'username' => 'required|min:4|max:30|unique:users,username',
                'password' => 'required|min:6|confirmed'
            ],
            [
                'required' => ':attribute harus diisi.',
                'nama_lengkap.min' => 'Minimal panjang karakter 6.',
                'nama_lengkap.max' => 'Maksimal panjang karakter 50.',
                'username.min' => 'Minimal panjang karakter 4.',
                'username.max' => 'Maksimal panjang karakter 30.',
                'password.min' => 'Minimal panjang karakter 6.',
                'confirmed' => 'Password tidak sesuai.',
                'username.unique' => ':attribute telah terdaftar.'
            ],
            [
                'nama_lengkap' => 'Nama lengkap',
                'username' => 'Username',
                'password' => 'Password',
                'password_confirmation' => 'Konfirmasi password'
            ]
        );

        try{
            $newAdmin = new User;
            $newAdmin->name = $request->get('nama_lengkap');
            $newAdmin->username = $request->get('username');
            $newAdmin->password = \Hash::make($request->get('password'));
            if($request->file('photo_profile') != null) {
                $folder = 'upload/admin/'.$request->get('username');
                $file = $request->file('photo_profile');
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
                    $newAdmin->profile_photo = $folder.'/'.$filename;
                }
            }
            $newAdmin->save();
            return redirect('master/user')->withStatus('Berhasil menambah data.');
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
    public function edit($id)
    {
        try{
            $this->param['subtitle'] = 'Edit';
            $this->param['top_button'] = route('user.index');
            $this->param['user'] = User::find($id);
            
            return view('backend.user.edit', $this->param);
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
    public function update(Request $request, $id)
    {
        try{
            $updateAdmin = User::find($id);

            $isUnique = $updateAdmin->username == $request->username ? '' : '|unique:users,username';
            $foto = $updateAdmin->profile_photo;

            $this->validate($request, 
                [
                    'nama_lengkap' => 'required|min:6|max:50',
                    'username' => 'required|min:4|max:30|'.$isUnique,
                    'password' => 'required|min:6|confirmed'
                ],
                [
                    'required' => ':attribute harus diisi.',
                    'nama_lengkap.min' => 'Minimal panjang karakter 6.',
                    'nama_lengkap.max' => 'Maksimal panjang karakter 50.',
                    'username.min' => 'Minimal panjang karakter 4.',
                    'username.max' => 'Maksimal panjang karakter 30.',
                    'password.min' => 'Minimal panjang karakter 6.',
                    'confirmed' => 'Password tidak sesuai.',
                    'username.unique' => ':attribute telah terdaftar.'
                ],
                [
                    'nama_lengkap' => 'Nama lengkap',
                    'username' => 'Username',
                    'password' => 'Password',
                    'password_confirmation' => 'Konfirmasi password'
                ]
            );

            $updateAdmin->name = $request->get('nama_lengkap');
            $updateAdmin->username = $request->get('username');
            $updateAdmin->password = \Hash::make($request->get('password'));

            if($request->file('photo_profile') != null) {
                return 'halo';
                $folder = 'upload/admin/'.$request->get('username');
                $file = $request->file('photo_profile');
                $filename = date('YmdHis').$file->getClientOriginalName();
                // Get canonicalized absolute pathname
                $path = realpath($folder);

                // If it exist, check if it's a directory
                if(!($path !== true AND is_dir($path)))
                {
                    // Path/folder does not exist then create a new folder
                    mkdir($folder, 0755, true);
                }
                if(file_exists($foto)){
                    if(File::delete($foto)){
                        if($file->move($folder, $filename)) {
                            $updateAdmin->profile_photo = $folder.'/'.$filename;
                        }
                    }
                }
            }
            $updateAdmin->save();
            return redirect('master/user')->withStatus('Berhasil menyimpan data.');
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
    public function destroy($id)
    {
        try{
            $user = User::find($id);
            $foto = $user->profile_photo;
            if($foto != null){
                if(file_exists($foto)){
                    if(File::delete($foto)){
                        $user->delete();
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
