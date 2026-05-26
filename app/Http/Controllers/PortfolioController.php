<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = \App\Models\Portfolio::where('is_active', true)->latest()->get();
        $sections = $portfolios->pluck('section')->unique();
        
        return view('portfolio', compact('portfolios', 'sections'));
    }
}
