<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::orderBy('updated_at', 'desc')->get();
        return view('backend.v_supplier.index', [
            'judul' => 'Data Supplier',
            'index' => $supplier
        ]);
    }

    public function create()
    {
        return view('backend.v_supplier.create', ['judul' => 'Tambah Supplier']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|max:255',
            'no_telp' => 'required|numeric',
        ]);
        Supplier::create($validated);
        return redirect()->route('backend.supplier.index')->with('success', 'Data berhasil disimpan');
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}