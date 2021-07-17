<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\AndroidUsers;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $data = null;
        $status = null;
        $msg = null;
        try {
            $data = AndroidUsers::where('username', $request->get('username'))->first();

            $status = 200;

            if($data != null) {
                if(\Hash::check($request->get('password'), $data->password)) {
                    // jika password sesuai
                    $msg = 'Berhasil';
                }
                else {
                    // jika password tidak sesuai
                    $msg = 'Password salah';
                    $data = null;
                }
            }
            else {
                $msg = 'Akun tidak ditemukan';
                $data = null;
            }
        }
        catch (\Exception $e) {
            $data = 'error';
            $status = 400;
            $msg = $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e) {
            $data = 'database error';
            $status = 400;
            $msg = $e->getMessage();
        }
        finally{
            $result = [
                'status' => $status,
                'message' => $msg,
                'data' => $data,
            ];
            return response($result, $status);
        }
    }

    public function register(Request $request)
    {
        $status = null;
        $msg = null;
        try {
            $newUser = new AndroidUsers;
            $newUser->name = $request->get('nama_lengkap');
            $newUser->username = $request->get('username');
            $newUser->phone = $request->get('no_hp');
            $newUser->password = \Hash::make($request->get('password'));

            $newUser->save();
            
            $status = 200;
            $msg = 'Berhasil';
        }
        catch (\Exception $e) {
            $status = 400;
            $msg = $e->getMessage();
        }
        catch(\Illuminate\Database\QueryException $e) {
            $status = 400;
            $msg = $e->getMessage();
        }
        finally{
            $result = [
                'status' => $status,
                'message' => $msg,
            ];
            return response($result, $status);
        }
    }
}
