<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Ingredients;
use App\Models\Products;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IngredientController extends Controller
{
    private $param;
    public function __construct()
    {
        $this->param['title'] = 'Bahan-bahan';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->param['subtitle'] = 'List Bahan';
        $this->param['data'] = Ingredients::select('ingredients.*', 'recipe.name AS recipe_name', 'products.name AS product_name')
                                        ->join('products', 'products.product_code', 'ingredients.product_code')
                                        ->join('recipe', 'recipe.recipe_code', 'ingredients.recipe_code')
                                        ->orderBy('ingredients.recipe_code', 'ASC')
                                        ->get();

        // return $this->param['data'];
        $this->param['top_button'] = route('ingredients.create');

        return view('backend.ingredients.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['subtitle'] = 'Tambah Bahan';
        $this->param['top_button'] = route('ingredients.index');
        $this->param['recipe'] = Recipe::orderBy('name')->get();
        $this->param['product'] = Products::orderBy('name')->get();

        return view('backend.ingredients.create', $this->param);
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
                'recipe_code' => 'not_in:0',
                'product_code' => 'not_in:0',
                'dose' => 'required'
            ],
            [
                'not_in' => ':attribute harus dipilih.',
                'required' => ':attribute harus diisi.'
            ],
            [
                'recipe_code' => 'Resep',
                'product_code' => 'Bahan',
                'dose' => 'Takaran'
            ]
        );

        try{
            $newIngredient = new Ingredients;
            $newIngredient->product_code = $request->get('product_code');
            $newIngredient->recipe_code = $request->get('recipe_code');
            $newIngredient->dose = $request->get('dose');

            $newIngredient->save();

            return redirect('master/ingredients')->withStatus('Berhasil menambah data.');
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $this->param['subtitle'] = 'List Bahan';
            $this->param['top_button'] = route('ingredients.index');

            $this->param['recipe'] = Recipe::orderBy('name')->get();
            $this->param['product'] = Products::orderBy('name')->get();

            $this->param['ingredient'] = Ingredients::find($id);

            return view('backend.ingredients.edit', $this->param);
        }
        catch(\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e) {
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
        $this->validate($request,
            [
                'recipe_code' => 'not_in:0',
                'product_code' => 'not_in:0',
                'dose' => 'required'
            ],
            [
                'not_in' => ':attribute harus dipilih.',
                'required' => ':attribute harus diisi.'
            ],
            [
                'recipe_code' => 'Resep',
                'product_code' => 'Bahan',
                'dose' => 'Takaran'
            ]
        );

        try{
            $editIngredient = Ingredients::find($id);
            $editIngredient->product_code = $request->get('product_code');
            $editIngredient->recipe_code = $request->get('recipe_code');
            $editIngredient->dose = $request->get('dose');

            $editIngredient->save();

            return redirect('master/ingredients')->withStatus('Berhasil menyimpan data.');
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
    public function destroy($recipeCode)
    {
        try{
            DB::table('ingredients')->where('recipe_code', '=', $recipeCode)->delete();
            
            return redirect('master/ingredients')->withStatus('Berhasil menghapus data.');
        }
        catch(\Exception $e){
            return redirect()->back()->withError($e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
