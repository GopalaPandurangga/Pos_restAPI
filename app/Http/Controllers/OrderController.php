<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
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

        $query = Order::query();

        if ($request->has('sort_by')) {
            $sortColumn = $request->input('sort_by');
            $sortType = $request->input('sort_type');
            $query->orderBy($sortColumn, $sortType);
        }

        $perPage = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $orders = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json(['data' => $orders = Order::where('owner_id', $validateData)->with('orderDetail')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $order = Order::create([
                'owner_id' => auth()->user()->id,
                'table_number' => $request->input('table_number'),
                'total' => $request->input('total'),
                'status' => 'pending',
            ]);

            // Simpan detail pesanan
            $items = $request->input('order_detail');

            foreach ($items as $item) {
                OrderDetails::create([
                    'order_id' => $order->id,
                    'product_id' => $item["product_id"],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            $table = Table::find($request->input('table_number'));

            $table->update([
                'order_id' => $order->id,
                'status' => "used"
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Post berhasil di buat',
                'data' => $order
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Err',
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function updateStatus(Request $request)
    {
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
