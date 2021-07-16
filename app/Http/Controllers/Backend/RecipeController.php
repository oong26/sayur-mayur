<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Ingredients;
use App\Models\Products;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;

class RecipeController extends Controller
{
    private $param;
    public function __construct()
    {
        $this->param['title'] = 'Resep';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->param['subtitle'] = 'List Resep';
        $this->param['data'] = Recipe::orderBy('recipe_code', 'ASC')
                                        ->get();
        $this->param['top_button'] = route('recipe.create');

        return view('backend.recipe.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['subtitle'] = 'Tambah Resep';
        $this->param['top_button'] = route('recipe.index');
        $recipeCode = null;
        $recipe = Recipe::orderBy('recipe_code', 'DESC')->get();
        $this->param['product'] = Products::orderBy('product_code', 'ASC')->get();
        
        if($recipe->count() > 0){
            $recipeCode = $recipe[0]->recipe_code;

            $lastIncrement = substr($recipeCode, 2);

            $recipeCode = str_pad($lastIncrement + 1, 3, 0, STR_PAD_LEFT);
            $recipeCode = 'RC'.$recipeCode;
            
        }
        else{
            $recipeCode = "RC001";
        }
        $this->param['recipe_code'] = $recipeCode;

        return view('backend.recipe.create', $this->param);
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
                'recipe_code' => 'required',
                'recipe_name' => 'required|min:3|max:50|unique:recipe,name',
                'cover' => 'required',
                'stock' => 'required',
                'laba' => 'required'
            ],
            [
                'required' => ':attribute harus diisi.',
                'recipe_name.min' => 'Minimal panjang karakter 3.',
                'recipe_name.max' => 'Maksimal panjang karakter 50.',
                'unique' => ':attribute telah terdaftar.'
            ],
            [
                'recipe_code' => 'Kode resep',
                'recipe_name' => 'Nama resep',
                'cover' => 'Foto Sampul',
                'stock' => 'Stok',
                'laba' => 'Laba'
            ]
        );

        try{
            $price = $request->get('laba');
            if($request->file('cover') != null) {
                $folder = 'upload/recipe/'.$request->get('recipe_code');
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
                    DB::table('recipe')->insert([
                        'recipe_code' => $request->get('recipe_code'),
                        'name' => $request->get('recipe_name'),
                        'cover' => $folder.'/'.$filename,
                        'stock' => $request->get('stock'),
                        'price' => $price,
                    ]);
                }
            }

            return redirect('master/recipe')->withStatus('Berhasil menambah data.');
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
    public function show($recipeCode)
    {
        try {
            $this->param['subtitle'] = 'Detail resep';
            $this->param['top_button'] = route('ingredients.index');
            $this->param['recipe'] = Recipe::select('name')->where('recipe_code', $recipeCode)->first();
            $this->param['recipe_item'] = Ingredients::select('ingredients.*', 'products.name AS product_name')
                                                    ->join('products', 'products.product_code', 'ingredients.product_code')
                                                    ->where('recipe_code', $recipeCode)
                                                    ->orderBy('products.name')
                                                    ->get();

            return view('backend.recipe.detail', $this->param);
        }
        catch(\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($recipeCode)
    {
        try{
            $this->param['subtitle'] = 'Edit';
            $this->param['top_button'] = route('recipe.index');
            $this->param['recipe'] = Recipe::where('recipe_code', $recipeCode)->first();
            
            return view('backend.recipe.edit', $this->param);
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
    public function update(Request $request, $recipeCode)
    {
        try{
            $recipe = Recipe::where('recipe_code', $recipeCode)->first();

            $isUnique = $recipe->name == $request->recipe_name ? '' : '|unique:recipe,name';
            $cover = $recipe->cover;

            $this->validate($request, 
                [
                    'recipe_code' => 'required',
                    'recipe_name' => 'required|min:3|max:50'.$isUnique,
                    'stock' => 'required',
                    'laba' => 'required',
                    'is_visible' => 'required'
                ],
                [
                    'required' => ':attribute harus diisi.',
                    'recipe_name.min' => 'Minimal panjang karakter 3.',
                    'recipe_name.max' => 'Maksimal panjang karakter 50.',
                    'unique' => ':attribute telah terdaftar.'
                ],
                [
                    'recipe_code' => 'Kode resep',
                    'recipe_name' => 'Nama resep',
                    'stock' => 'Stok',
                    'laba' => 'Laba',
                    'is_visible' => 'Pilihan'
                ]
            );

            if($request->file('cover') != null) {
                $folder = 'upload/recipe/'.$request->get('recipe_code');
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
                                DB::table('recipe')->where('recipe_code', $recipeCode)->update([
                                    'name' => $request->get('recipe_name'),
                                    'cover' => $folder.'/'.$filename,
                                    'stock' => $request->get('stock'),
                                    'price' => $request->get('laba'),
                                    'is_visible' => $request->get('is_visible'),
                                    'updated_at' => time()
                                ]);
                            }
                        }
                    }
                }
            }
            else {
                DB::table('recipe')->where('recipe_code', $recipeCode)->update([
                    'name' => $request->get('recipe_name'),
                    'stock' => $request->get('stock'),
                    'price' => $request->get('laba'),
                    'is_visible' => $request->get('is_visible'),
                    'updated_at' => time()
                ]);
            }

            return redirect('master/recipe')->withStatus('Berhasil menyimpan perubahan.');
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
            $recipe = Recipe::where('recipe_code', $recipeCode)->first();

            $cover = $recipe->cover;
            if($cover != null){
                if(file_exists($cover)){
                    if(File::delete($cover)){
                        Recipe::where('recipe_code', $recipeCode)->delete();
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
