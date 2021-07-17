<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ingredients;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function allRecipe()
    {
        $data = null;
        $status = null;
        $msg = null;
        try {
            $data = Recipe::orderBy('name', 'ASC')->get();
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

    public function ingredients($recipe_code)
    {
        $data = null;
        $status = null;
        $msg = null;
        try {
            $data = Ingredients::select('ingredients.product_code', 'ingredients.dose', 'products.name', 'products.cover')
                                ->join('products', 'products.product_code', 'ingredients.product_code')
                                ->where('ingredients.recipe_code', $recipe_code)
                                ->orderBy('products.name', 'ASC')
                                ->get();

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
