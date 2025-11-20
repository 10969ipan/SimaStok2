<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Tambahkan ini biar bisa ambil data user

class BerandaController extends Controller
{
    public function berandaBackend()
    {
        $index = User::all(); // Ambil semua data user

        return view('backend.v_beranda.index', [
            'judul' => 'Halaman Beranda',
            'index' => $index
        ]);
    }
}
