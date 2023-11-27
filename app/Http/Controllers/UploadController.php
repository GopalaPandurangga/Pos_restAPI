<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function upload(Request $request)
    {
        try {
            if ($request->file('photo')) {
                $path = $request->file('photo')->store('covers');
                $assetUrl = Storage::url($path);
                $url = asset($assetUrl); // Get the full URL of the stored photo

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil upload photo',
                    'data' => [
                        'asset_url' => $assetUrl, // Include the full photo URL in the response
                        'url' => $url, // Include the full photo URL in the response
                    ],
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No photo uploaded',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Err',
                'errors' => $e->getMessage(),
            ]);
        }
    }
}
