<?php

namespace App\Http\Controllers;

use App\Models\PengajuanBerita;
use App\Models\KategoriBerita;
use App\Models\ProdiUnit;
use App\Models\LogAksiAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\RecaptchaV2;

class PengajuanBeritaController extends Controller
{
    // Dashboard User
    public function userDashboard()
    {
        $userId = Auth::id() ?? 1;

        // Count antrean pengajuan: hanya pengajuan user yang masih berstatus 'In Review'
        // Jika sudah direview oleh admin (In Progress, Publish, atau Rejected), otomatis berkurang / jadi 0
        $antrianCount = PengajuanBerita::where('user_id', $userId)
            ->where('status', 'In Review')
            ->count();

        // Count publikasi berita: pengajuan milik user yang sudah publish
        $publikasiCount = PengajuanBerita::where('user_id', $userId)
            ->where('status', 'Publish')
            ->count();

        return view('user.dashboard', compact('antrianCount', 'publikasiCount'));
    }

    // Form Pengajuan Berita (User)
    public function create()
    {
        $prodiList = ProdiUnit::all();
        $kategoriList = KategoriBerita::all();
        return view('user.pengajuan', compact('prodiList', 'kategoriList'));
    }

    // Simpan Pengajuan Baru dari User
    public function store(Request $request)
    {
        $request->validate([
            'judul_berita' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_berita,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'narasi_berita' => 'required|string',
            'link_dokumentasi' => 'required|url',
            'kontak_person' => 'required|string|max:15',
            'g-recaptcha-response' => [
                'required',
                'string',
                'max:4096',
                new RecaptchaV2(),
            ],
        ]);

        PengajuanBerita::create([
            'user_id' => Auth::id() ?? 1,
            'judul_berita' => $request->judul_berita,
            'kategori_id' => $request->kategori_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'narasi_berita' => $request->narasi_berita,
            'link_dokumentasi' => $request->link_dokumentasi,
            'kontak_person' => $request->kontak_person,
            'status' => 'In Review',
        ]);

        return redirect()->route('user.monitoring')->with('success', 'Pengajuan berita berhasil dikirim!');
    }

    // Monitoring Status (User)
    public function monitoring()
    {
        $pengajuan = PengajuanBerita::with(['kategori', 'logAksi'])
            ->where('user_id', Auth::id() ?? 1)
            ->latest()
            ->paginate(10);

        return view('user.monitoring', compact('pengajuan'));
    }

    // Dashboard Admin
    public function adminDashboard()
    {
        $antreanCount = PengajuanBerita::where('status', 'In Review')->count();
        $publikasiCount = PengajuanBerita::where('status', 'Publish')->count();
        $masukCount = PengajuanBerita::count();

        $antreanList = PengajuanBerita::with(['user.prodiUnit', 'kategori'])
            ->where('status', 'In Review')
            ->latest()
            ->paginate(10);

        return view('admin.dashboard', compact('antreanCount', 'publikasiCount', 'masukCount', 'antreanList'));
    }

    // Kelola Pengajuan (Admin)
    public function index()
    {
        $pengajuanList = PengajuanBerita::with(['user.prodiUnit', 'kategori', 'logAksi'])->latest()->paginate(10);
        $kategoriList = KategoriBerita::all();
        $prodiList = ProdiUnit::all();

        return view('admin.kelola-pengajuan', compact('pengajuanList', 'kategoriList', 'prodiList'));
    }

    // Detail Pengajuan (Admin Read-Only)
    public function show($id)
    {
        $pengajuan = PengajuanBerita::with(['user.prodiUnit', 'kategori', 'logAksi'])->findOrFail($id);
        return view('admin.detail-pengajuan', compact('pengajuan'));
    }

    // Update Status Pengajuan & Catat Log (Admin)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:In Review,In Progress,Publish,Rejected',
            'link_publikasi' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $pengajuan = PengajuanBerita::findOrFail($id);
        $statusSebelumnya = $pengajuan->status;

        $updateData = [
            'status' => $request->status,
        ];

        if ($request->filled('link_publikasi')) {
            $updateData['link_publikasi'] = $request->link_publikasi;
        }

        $pengajuan->update($updateData);

        // Catat log perubahan status beserta alasan (catatan)
        LogAksiAdmin::create([
            'pengajuan_id' => $pengajuan->id,
            'admin_id' => Auth::id() ?? 1,
            'status_sebelumnya' => $statusSebelumnya,
            'status_baru' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Status pengajuan berhasil diperbarui!');
    }

    // Rekapitulasi Laporan (Admin)
    public function rekapitulasi()
    {
        $rekapData = PengajuanBerita::with(['user.prodiUnit', 'kategori'])->latest()->get();
        return view('admin.rekapitulasi', compact('rekapData'));
    }
}
