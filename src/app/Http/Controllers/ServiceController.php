<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return view('services.index');
    }

    public function show($id)
    {
        return view('services.show', compact('id'));
    }

    public function create()
    {
        return view('freelancer.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:non_project,project',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        // Simpan data jika sudah siap integrasi dengan model/database

        return redirect()->route('freelancer.dasbor')->with('success', 'Jasa berhasil dipublikasikan!');
    }
}
