<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dashboard()
    {
        return response()->json([
            'message' => 'Welcome to Admin Dashboard',
            'status' => 'success',
        ]);
    }
}
