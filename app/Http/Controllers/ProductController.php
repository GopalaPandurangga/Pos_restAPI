<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\User;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    // Mendapatkan informasi pengguna yang sedang login
        $user = Auth::user();

    // Mengatur owner_id dengan nilai user_id dari pengguna yang sedang login
        $validateData['owner_id'] = $user->id;


    // Lakukan query untuk mendapatkan produk berdasarkan owner_id
       
        $query = Product::query();
       

        if ($request->has('sort_by')) {
            $sortColumn = $request->input('sort_by');
            $sortType = $request->input('sort_type');
            $query->orderBy($sortColumn, $sortType);
        }

        $perPage = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $products = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json(  ['data' => $products = Product::where('owner_id', $validateData)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
           
            'photo' => 'required',
            'product_name' => 'required|string',
            'price' => 'required',
            'category' => 'required|string',
            'description' => 'required',

        ]);
        try {
             // Mendapatkan informasi pengguna yang sedang login
            $user = Auth::user();

            // Mengatur owner_id dengan nilai user_id dari pengguna yang sedang login
            $validateData['owner_id'] = $user->id;


            if ($request->file('photo')) {
                $validateData['photo'] = $request->file('photo')->store('covers');
            }

            $product = Product::create($validateData);

            if ($product != null) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post berhasil di buat',
                    'data' => $product
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post gagal di buat',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Err',
                'errors' => $e->getMessage()
            ]);
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
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validateData = $request->validate([
            'photo' => 'required',
            'product_name' => 'required|string',
            'price' => 'required',
            'category' => 'required|string',
            'description' => 'required',
        ]);
    
        try {
            // Mendapatkan informasi pengguna yang sedang login
            $user = Auth::user();
    
            // Mengatur owner_id dengan nilai user_id dari pengguna yang sedang login
            $validateData['owner_id'] = $user->id;
    
            if ($request->file('photo')) {
                $validateData['photo'] = $request->file('photo')->store('covers');
            }
    
            // Mengupdate produk berdasarkan ID
            $product = Product::find($id);
    
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan',
                ]);
            }
    
            $product->update($validateData);
    
            // Cetak informasi produk yang diperbarui ke konsol
            dd($product);
    
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui',
                'data' => $product
            ]);
        } catch (\Exception $e) {
            // Cetak pesan kesalahan ke konsol
            dd($e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'errors' => $e->getMessage()
            ]);
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
        $product = Product::find($id);
        $product->delete();
        return response()->json(null, 204);
    }
}
