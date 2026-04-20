<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index()
    {
        return view('auth.verify-ktm');
    }

    public function store(Request $request)
    {
        // Validasi dan penyimpanan file KTM bla bla bla
        return redirect()->route('dashboard')->with('success', 'Berhasil submit KTM. Silakan tunggu verifikasi tim SkillKul.');
    }
}
