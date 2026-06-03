<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = \App\Models\Portfolio::with('service')
            ->where('is_active', true)
            ->latest()
            ->get();

        $groupedPortfolios = $portfolios->groupBy(function($item) {
            return $item->service ? $item->service->name : ($item->section ?: 'General');
        });
        
        return view('portfolio', compact('groupedPortfolios'));
    }
}
