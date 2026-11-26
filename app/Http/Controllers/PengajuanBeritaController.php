<?php

namespace App\Http\Controllers;

use App\Models\PengajuanBerita;
use App\Models\KategoriBerita;
use App\Models\ProdiUnit;
use App\Models\LogAksiAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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
    public function adminDashboard(Request $request)
    {
        $antreanCount = PengajuanBerita::where('status', 'In Review')->count();
        $publikasiCount = PengajuanBerita::where('status', 'Publish')->count();
        $masukCount = PengajuanBerita::count();

        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, [10, 25, 50], true)) {
            $perPage = 10;
        }

        $search = trim((string) $request->input('search', ''));

        $antreanQuery = PengajuanBerita::with(['user.prodiUnit', 'kategori'])
            ->where('status', 'In Review')
            ->latest();

        if ($search !== '') {
            $antreanQuery->where(function ($q) use ($search) {
                $q->where('judul_berita', 'like', "%{$search}%")
                    ->orWhereHas('kategori', function ($kq) use ($search) {
                        $kq->where('nama_kategori', 'like', "%{$search}%");
                    });
            });
        }

        $antreanList = $antreanQuery->paginate($perPage)->withQueryString();

        if ($request->expectsJson() || $request->ajax()) {
            $rows = $antreanList->getCollection()->map(function ($item) {
                return [
                    'tanggal' => Carbon::parse($item->tanggal_mulai)->format('d/m/Y'),
                    'judul_berita' => $item->judul_berita,
                    'kategori' => $item->kategori->nama_kategori ?? '-',
                    'status' => $item->status,
                    'show_url' => route('admin.pengajuan.show', $item->id),
                ];
            })->values()->all();

            return response()->json([
                'antreanCount' => $antreanCount,
                'publikasiCount' => $publikasiCount,
                'masukCount' => $masukCount,
                'rows' => $rows,
            ]);
        }

        return view('admin.dashboard', compact('antreanCount', 'publikasiCount', 'masukCount', 'antreanList', 'perPage', 'search'));
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
    public function rekapitulasi(Request $request)
    {
        $payload = $this->buildRekapPayload($request);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'rows' => $payload['rows'],
                'pie' => $payload['pie'],
                'status' => $payload['status'],
            ]);
        }

        $kategoriList = KategoriBerita::orderBy('nama_kategori')->get();

        return view('admin.rekapitulasi', [
            'rekapData' => $payload['records'],
            'rekapRows' => $payload['rows'],
            'pieChartData' => $payload['pie'],
            'statusCounts' => $payload['status'],
            'kategoriList' => $kategoriList,
            'filters' => [
                'periode' => $request->input('periode', ''),
                'tanggal' => $request->input('tanggal', ''),
                'kategori_id' => $request->input('kategori_id', ''),
            ],
        ]);
    }

    // Unduh Laporan Rekapitulasi (CSV kompatibel Excel)
    public function exportRekapitulasi(Request $request)
    {
        $rekapData = $this->filteredRekapQuery($request)->get();
        $filename = 'rekapitulasi-berita-' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($rekapData) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM agar karakter terbaca benar di Microsoft Excel
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['No', 'Unit', 'Tanggal', 'Judul Berita', 'Kategori Berita', 'Status', 'Link Publikasi']);

            foreach ($rekapData as $index => $item) {
                fputcsv($handle, [
                    $index + 1,
                    $item->user->prodiUnit->nama_prodi_unit ?? '-',
                    $item->tanggal_mulai ? Carbon::parse($item->tanggal_mulai)->format('d/m/Y') : '-',
                    $item->judul_berita,
                    $item->kategori->nama_kategori ?? '-',
                    $item->status,
                    $item->link_publikasi ?? '-',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Bangun query pengajuan berita berdasarkan filter periode, tanggal, dan kategori.
     */
    private function filteredRekapQuery(Request $request)
    {
        $query = PengajuanBerita::with(['user.prodiUnit', 'kategori'])->latest();

        $periode = $request->input('periode');
        $tanggal = $request->input('tanggal');
        $kategoriId = $request->input('kategori_id');

        if (!empty($kategoriId)) {
            $query->where('kategori_id', $kategoriId);
        }

        $refDate = now();
        $hasValidTanggal = false;
        if (!empty($tanggal)) {
            try {
                $refDate = Carbon::parse($tanggal);
                $hasValidTanggal = true;
            } catch (\Throwable $e) {
                $hasValidTanggal = false;
            }
        }

        $quarterMonths = [
            'q1' => [1, 3],
            'q2' => [4, 6],
            'q3' => [7, 9],
            'q4' => [10, 12],
        ];

        if ($periode === 'bulanan') {
            $query->whereYear('tanggal_mulai', $refDate->year)
                ->whereMonth('tanggal_mulai', $refDate->month);
        } elseif (isset($quarterMonths[$periode])) {
            [$startMonth, $endMonth] = $quarterMonths[$periode];
            $query->whereYear('tanggal_mulai', $refDate->year)
                ->whereMonth('tanggal_mulai', '>=', $startMonth)
                ->whereMonth('tanggal_mulai', '<=', $endMonth);
        } elseif ($hasValidTanggal) {
            $query->whereDate('tanggal_mulai', $refDate->toDateString());
        }

        return $query;
    }

    /**
     * Siapkan data tabel serta agregasi grafik untuk tampilan maupun endpoint JSON real-time.
     */
    private function buildRekapPayload(Request $request): array
    {
        $records = $this->filteredRekapQuery($request)->get();

        $pieGrouped = $records->groupBy(function ($item) {
            $kategori = $item->kategori->nama_kategori ?? 'Tanpa Kategori';
            $unit = $item->user->prodiUnit->nama_prodi_unit ?? 'Tanpa Unit';
            return "{$kategori} ({$unit})";
        })->map->count()->sortDesc();

        $rows = $records->map(function ($item) {
            return [
                'id' => $item->id,
                'unit' => $item->user->prodiUnit->nama_prodi_unit ?? '-',
                'tanggal' => $item->tanggal_mulai ? Carbon::parse($item->tanggal_mulai)->format('d/m/Y') : '-',
                'judul_berita' => $item->judul_berita,
                'show_url' => route('admin.pengajuan.show', $item->id),
                'kategori' => $item->kategori->nama_kategori ?? '-',
                'status' => $item->status,
                'link_publikasi' => $item->link_publikasi ?: null,
            ];
        })->values()->all();

        return [
            'records' => $records,
            'rows' => $rows,
            'pie' => [
                'labels' => $pieGrouped->keys()->values()->all(),
                'data' => $pieGrouped->values()->all(),
            ],
            'status' => [
                'publish' => $records->where('status', 'Publish')->count(),
                'rejected' => $records->where('status', 'Rejected')->count(),
            ],
        ];
    }
}
