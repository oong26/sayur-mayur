<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function newerRecipe()
    {
        $data = null;
        $status = null;
        $msg = null;
        try {
            $data = Recipe::orderBy('recipe_code', 'DESC')->take(10)->get();
            $status = 200;
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

    public function recipe()
    {
        $data = null;
        $status = null;
        $msg = null;
        try {
            $data = Recipe::orderBy('name', 'ASC')->take(4)->get();
            $status = 200;
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
}
