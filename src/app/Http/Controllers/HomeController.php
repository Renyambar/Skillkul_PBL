<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama aplikasi.
     */
    public function index()
    {
        // Ambil 6 jasa aktif terbaru untuk ditampilkan di landing page
        $featuredServices = Service::with(['freelancer', 'category'])
            ->where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        // Ambil semua kategori untuk filter pills
        $categories = Category::orderBy('name')->get();

        return view('welcome', compact('featuredServices', 'categories'));
    }
}
