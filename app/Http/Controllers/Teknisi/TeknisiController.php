<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeknisiController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard teknisi.
     */
    public function index()
    {
        // Untuk sementara, kita tampilkan teks dulu untuk tes
        return view('teknisi.dashboard');
    }
}