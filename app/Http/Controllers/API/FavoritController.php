<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favorit;
use Illuminate\Http\Request;

class FavoritController extends Controller
{
    public function addFavorit(Request $request)
    {
        $status = null;
        $msg = null;
        try {
            $currentFavorit = Favorit::where('recipe_code', $request->get('recipe_code'))
                                    ->where('android_user_id', $request->get('id_user'))
                                    ->count();

            if($currentFavorit > 0) {
                $msg = 'Sudah ditambahkan ke favorit';
            }
            else {
                $newFavorit = new Favorit;
                $newFavorit->recipe_code = $request->get('recipe_code');
                $newFavorit->android_user_id = $request->get('id_user');
    
                $newFavorit->save();

                $msg = 'Berhasil';
            }
            
            $status = 200;
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

    public function deleteFavorit($id_user, $recipe_code)
    {
        $status = null;
        $msg = null;
        try {
            $favorit = Favorit::where('android_user_id', $id_user)->where('recipe_code', $recipe_code)->first();
            $favorit->delete();
            
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

    public function listFavorit($id)
    {
        $data = null;
        $status = null;
        $msg = null;
        try {
            $data = Favorit::select('favorit.id AS id_favorit', 'recipe.*')
                            ->join('recipe', 'recipe.recipe_code', 'favorit.recipe_code')
                            ->where('favorit.android_user_id', $id)
                            ->orderBy('recipe.name', 'ASC')
                            ->get();
                            
            $status = 200;
            $msg = 'Berhasil';
        }
        catch (\Exception $e) {
            $status = 400;
            $msg = $e->getMessage();
            $data = null;
        }
        catch(\Illuminate\Database\QueryException $e) {
            $status = 400;
            $msg = $e->getMessage();
            $data = null;
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

    public function checkFavorit($id_user, $recipe_code)
    {
        $status = null;
        $msg = null;
        try {
            $currentFavorit = Favorit::where('recipe_code', $recipe_code)
                                    ->where('android_user_id', $id_user)
                                    ->count();

            if($currentFavorit > 0) {
                $msg = 'Sudah favorit';
            }
            else {
                $msg = 'Belum favorit';
            }

            $status = 200;
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
                'message' => $msg
            ];
            return response($result, $status);
        }
    }
}
