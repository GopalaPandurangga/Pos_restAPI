<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         // Mendapatkan informasi pengguna yang sedang login
         $user = Auth::user();

         // Mengatur owner_id dengan nilai user_id dari pengguna yang sedang login
             $validateData['owner_id'] = $user->id;
     
     
         // Lakukan query untuk mendapatkan produk berdasarkan owner_id
            
             $query = Table::query();
            
     
             if ($request->has('sort_by')) {
                 $sortColumn = $request->input('sort_by');
                 $sortType = $request->input('sort_type');
                 $query->orderBy($sortColumn, $sortType);
             }
     
             $perPage = $request->input('limit', 10);
             $page = $request->input('page', 1);
             $tables = $query->paginate($perPage, ['*'], 'page', $page);
     
             return response()->json(  ['data' => $tables = Table::where('owner_id', $validateData)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
