<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DesainKoleksi;
use App\Models\User;

class DesainKoleksiController extends Controller
{
    public function index()
    {
        $data = DesainKoleksi::with('user')->orderBy('updated_at', 'desc')->get();
        return view('backend.v_desain_koleksi.index', [
            'judul' => 'Data Desain Koleksi',
            'index' => $data
        ]);
    }

    public function create()
    {
        // Ambil user yang rolenya Staff/Desainer (Role 1) atau semua user
        $users = User::where('role', '1')->get(); 
        return view('backend.v_desain_koleksi.create', [
            'judul' => 'Tambah Desain',
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|max:255',
            'id_user'  => 'required|exists:user,id',
        ]);
        
        DesainKoleksi::create($validated);
        return redirect()->route('backend.desain_koleksi.index')->with('success', 'Data berhasil disimpan');
    }

    public function destroy($id)
    {
        DesainKoleksi::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}