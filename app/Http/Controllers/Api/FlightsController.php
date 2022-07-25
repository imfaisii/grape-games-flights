<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use Illuminate\Http\Request;

class FlightsController extends Controller
{
    public function index()
    {
        return response()->json([
            [
                'status' => 'success',
                'total_records' => Flight::count(),
                'data' => Flight::latest()->cursorPaginate(100),
            ]
        ], 200);
    }
}
