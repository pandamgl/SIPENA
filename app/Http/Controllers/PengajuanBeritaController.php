<?php

namespace App\Http\Controllers;

use App\Models\PengajuanBerita;
use App\Models\KategoriBerita;
use App\Models\ProdiUnit;
use App\Models\LogAksiAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanBeritaController extends Controller
{
    // Dashboard User
    public function userDashboard()
    {
        $userId = Auth::id() ?? 1;

        $totalPengajuan = PengajuanBerita::where('user_id', $userId)->count();
        $totalPublikasi = PengajuanBerita::where('user_id', $userId)
                                         ->where('status', 'Publish')
                                         ->count();

        return view('user.dashboard', compact('totalPengajuan', 'totalPublikasi'));
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

    // Monitoring Status (User) dengan Filter
    public function monitoring(Request $request)
    {
        $userId = Auth::id() ?? 1;

        $kategoriList = KategoriBerita::all();
        $query = PengajuanBerita::with('kategori')->where('user_id', $userId);

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuan = $query->latest()->paginate(10)->appends($request->query());

        return view('user.monitoring', compact('pengajuan', 'kategoriList'));
    }

    // Dashboard Admin
    public function adminDashboard()
    {
        $totalAntrean = PengajuanBerita::whereIn('status', ['In Review', 'In Progress'])->count();
        $totalPublikasi = PengajuanBerita::where('status', 'Publish')->count();
        $totalPengajuanMasuk = PengajuanBerita::count();
        
        $antreanList = PengajuanBerita::with(['user.prodiUnit', 'kategori'])->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalAntrean',
            'totalPublikasi',
            'totalPengajuanMasuk',
            'antreanList'
        ));
    }

    // Kelola Pengajuan (Admin) dengan Fitur Sorting / Filter Lengkap
    public function index(Request $request)
    {
        $query = PengajuanBerita::with(['user.prodiUnit', 'kategori']);

        // Filter berdasarkan Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_mulai', $request->bulan);
        }

        // Filter berdasarkan Tanggal Spesifik
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_mulai', $request->tanggal);
        }

        // Filter berdasarkan Kategori Berita
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter berdasarkan Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuanList = $query->latest()->paginate(10)->appends($request->query());
        $kategoriList = KategoriBerita::all();
        $prodiList = ProdiUnit::all();

        return view('admin.kelola-pengajuan', compact('pengajuanList', 'kategoriList', 'prodiList'));
    }

    // Form Tambah Berita Langsung oleh Admin
    public function adminCreate()
    {
        $prodiList = ProdiUnit::all();
        $kategoriList = KategoriBerita::all();
        return view('admin.tambah-berita', compact('prodiList', 'kategoriList'));
    }

    // Simpan Berita Langsung Publish dari Admin
    public function adminStore(Request $request)
    {
        $request->validate([
            'judul_berita' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_berita,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'narasi_berita' => 'required|string',
            'link_dokumentasi' => 'required|url',
            'kontak_person' => 'required|string|max:15',
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
            'status' => 'Publish',
        ]);

        return redirect()->route('admin.pengajuan.index')->with('success', 'Berita berhasil ditambahkan dan dipublikasikan!');
    }

    // Detail Pengajuan (Admin Read-Only)
    public function show($id)
    {
        $pengajuan = PengajuanBerita::with(['user.prodiUnit', 'kategori'])->findOrFail($id);
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

        $pengajuan->update([
            'status' => $request->status,
            'link_publikasi' => $request->link_publikasi ?? $pengajuan->link_publikasi,
        ]);

        LogAksiAdmin::create([
            'pengajuan_id' => $pengajuan->id,
            'admin_id' => Auth::id() ?? 1,
            'status_sebelumnya' => $statusSebelumnya,
            'status_baru' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Status pengajuan berhasil diperbarui!');
    }

    // Rekapitulasi Laporan (Admin) dengan Filter dan Ekspor Excel
    public function rekapitulasi(Request $request)
    {
        $query = PengajuanBerita::with(['user.prodiUnit', 'kategori'])
            ->whereIn('status', ['Publish', 'Rejected']);

        // Filter Berdasarkan Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_mulai', $request->bulan);
        }

        // Filter Berdasarkan Tanggal Spesifik
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_mulai', $request->tanggal);
        }

        // Filter Berdasarkan Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Fitur Unduh Laporan ke Excel
        if ($request->has('export') && $request->export == 'excel') {
            $rekapData = $query->latest()->get();
            
            $filename = "Rekapitulasi_SIPENA_" . date('Y-m-d') . ".xls";
            
            headers_sent() || header("Content-Type: application/vnd.ms-excel");
            headers_sent() || header("Content-Disposition: attachment; filename=\"$filename\"");
            
            echo "<table border='1'>";
            echo "<tr><th>No</th><th>Unit</th><th>Tanggal</th><th>Judul Berita</th><th>Kategori Berita</th><th>Status</th></tr>";
            foreach ($rekapData as $index => $item) {
                echo "<tr>";
                echo "<td>" . ($index + 1) . "</td>";
                echo "<td>" . ($item->user->prodiUnit->nama_prodi_unit ?? '-') . "</td>";
                echo "<td>" . \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') . "</td>";
                echo "<td>" . $item->judul_berita . "</td>";
                echo "<td>" . ($item->kategori->nama_kategori ?? '-') . "</td>";
                echo "<td>" . $item->status . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            exit;
        }

        $rekapData = $query->latest()->get();
        $kategoriList = KategoriBerita::all();

        $countPublish = (clone $query)->where('status', 'Publish')->count();
        $countRejected = (clone $query)->where('status', 'Rejected')->count();

        $kategoriStatistik = KategoriBerita::withCount(['pengajuanBerita' => function($q) use ($request) {
            $q->whereIn('status', ['Publish', 'Rejected']);
            if ($request->filled('bulan')) $q->whereMonth('tanggal_mulai', $request->bulan);
            if ($request->filled('tanggal')) $q->whereDate('tanggal_mulai', $request->tanggal);
            if ($request->filled('kategori')) $q->where('kategori_id', $request->kategori);
        }])->get();

        $kategoriLabels = $kategoriStatistik->pluck('nama_kategori');
        $kategoriCounts = $kategoriStatistik->pluck('pengajuan_berita_count');

        return view('admin.rekapitulasi', compact(
            'rekapData', 
            'kategoriList',
            'countPublish', 
            'countRejected', 
            'kategoriLabels', 
            'kategoriCounts'
        ));
    }
}