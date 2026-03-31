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
        // Siswa hanya lihat laporan sendiri, Guru lihat semua
        if (auth()->user()->role === 'siswa') {
            $pengaduan = Pengaduan::where('user_id', auth()->id())->latest()->paginate(10);
        } else {
            $pengaduan = Pengaduan::with('user')->latest()->paginate(10);
        }
        
        return view('pengaduan.index', compact('pengaduan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya siswa yang bisa buat laporan
        if (auth()->user()->role !== 'siswa') {
            abort(403, 'Hanya siswa yang dapat membuat laporan.');
        }
        
        return view('pengaduan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Hanya siswa yang bisa store laporan
        if (auth()->user()->role !== 'siswa') {
            abort(403, 'Hanya siswa yang dapat membuat laporan.');
        }

        $request->validate([
            'pesan_laporan' => 'required|string',
        ]);

        Pengaduan::create([
            'user_id' => auth()->id(),
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
        // Siswa hanya bisa lihat laporan sendiri, Guru bisa lihat semua
        if (auth()->user()->role === 'siswa' && $pengaduan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak dapat melihat laporan ini.');
        }
        
        return view('pengaduan.show', compact('pengaduan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengaduan $pengaduan)
    {
        // Hanya guru yang bisa edit status laporan
        if (auth()->user()->role !== 'guru') {
            abort(403, 'Hanya guru yang dapat mengupdate status laporan.');
        }
        
        return view('pengaduan.edit', compact('pengaduan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        // Hanya guru yang bisa update status laporan
        if (auth()->user()->role !== 'guru') {
            abort(403, 'Hanya guru yang dapat mengupdate status laporan.');
        }

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
        // Hanya guru yang bisa hapus laporan
        if (auth()->user()->role !== 'guru') {
            abort(403, 'Hanya guru yang dapat menghapus laporan.');
        }
        
        $pengaduan->delete();
        return redirect()->route('pengaduan.index')->with('success', 'Laporan berhasil dihapus!');
    }
}