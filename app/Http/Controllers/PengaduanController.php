<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengaduan = Pengaduan::with('user')->latest()->paginate(10);
        return view('pengaduan.index', compact('pengaduan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengaduan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
            'pesan_laporan' => 'required|string',
        ]);

        Pengaduan::create([
            'user_id' => auth()->id(),
            'kategori' => $request->kategori,
            'pesan_laporan' => $request->pesan_laporan,
            'status' => 'pending',
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Laporan berhasil dikirim!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengaduan $pengaduan)
    {
        return view('pengaduan.show', compact('pengaduan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengaduan $pengaduan)
    {
        return view('pengaduan.edit', compact('pengaduan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai,ditolak',
            'tanggapan_admin' => 'nullable|string',
        ]);

        $pengaduan->update([
            'status' => $request->status,
            'tanggapan_admin' => $request->tanggapan_admin,
            'admin_id' => auth()->id(),
            'selesai_at' => $request->status === 'selesai' ? now() : null,
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Laporan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengaduan $pengaduan)
    {
        $pengaduan->delete();
        return redirect()->route('pengaduan.index')->with('success', 'Laporan berhasil dihapus!');
    }
}