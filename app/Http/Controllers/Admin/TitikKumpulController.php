<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TitikKumpul;
use Illuminate\Http\Request;

class TitikKumpulController extends Controller
{
    public function index()
    {
        $titikKumpuls = TitikKumpul::latest()->get();
        return view('admin.titik-kumpul.index', compact('titikKumpuls'));
    }

    public function create()
    {
        return view('admin.titik-kumpul.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'kontak' => 'nullable|string|max:50',
        ]);

        TitikKumpul::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'kontak' => $request->kontak,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.titik-kumpul.index')
                         ->with('success', 'Titik kumpul berhasil ditambahkan.');
    }

    public function show(TitikKumpul $titikKumpul)
    {
        return view('admin.titik-kumpul.show', compact('titikKumpul'));
    }

    public function edit(TitikKumpul $titikKumpul)
    {
        return view('admin.titik-kumpul.edit', compact('titikKumpul'));
    }

    public function update(Request $request, TitikKumpul $titikKumpul)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'kontak' => 'nullable|string|max:50',
        ]);

        $titikKumpul->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'kontak' => $request->kontak,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.titik-kumpul.index')
                         ->with('success', 'Titik kumpul berhasil diperbarui.');
    }

    public function destroy(TitikKumpul $titikKumpul)
    {
        $titikKumpul->delete();
        return redirect()->route('admin.titik-kumpul.index')
                         ->with('success', 'Titik kumpul berhasil dihapus.');
    }

    // 🔁 Toggle status langsung dari tabel
    public function toggleStatus($id)
    {
        $titikKumpul = TitikKumpul::findOrFail($id);
        $titikKumpul->is_active = !$titikKumpul->is_active;
        $titikKumpul->save();

        return redirect()->route('admin.titik-kumpul.index')
                         ->with('success', 'Status titik kumpul berhasil diubah.');
    }
}