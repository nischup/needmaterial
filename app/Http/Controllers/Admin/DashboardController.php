<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('super_admin')) {
               return view('admin.dashboard');
        }

        return redirect()->route('frontend.dashboard');
    }
}
