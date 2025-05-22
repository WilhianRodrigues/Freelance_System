<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Exibir a visão geral do dashboard
        return view('dashboard');
    }
}

