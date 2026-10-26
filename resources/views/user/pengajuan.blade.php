@extends('layouts.user')

@section('title', 'Pengajuan Berita - SIPENA')

@push('styles')
    <style>
        /* Header Halaman (Banner Abu-abu) */
        .page-header {
            background-color: #f0f0f0;
            padding: 20px 40px;
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 28px;
            color: #1a1a1a;
            font-weight: 600;
        }

        /* Form Area */
        .form-container {
            padding: 0 40px 50px 40px;
            max-width: 1000px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            margin-top: 35px;
            color: #1a1a1a;
        }

        .form-label {
            display: block;
            font-size: 15px;
            margin-bottom: 8px;
            color: #1a1a1a;
        }

        /* Styling Input Box (Abu-abu terang) */
        .form-control {
            width: 100%;
            padding: 14px 18px;
            background-color: #e3e3e3;
            border: 2px solid transparent;
            border-radius: 8px;
            font-size: 14px;
            color: #333;
            font-family: inherit;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-control:focus {
            border: 2px solid #a0a0a0;
            background-color: white;
        }

        .form-control:valid {
            background-color: white;
            border: 2px solid #1a1a1a;
        }

        .form-control::placeholder {
            color: #666;
        }

        /* Layout Grid untuk Form */
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        /* Khusus input tanggal berdampingan (Dari - Sampai) */
        .date-range {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Textarea untuk Narasi */
        textarea.form-control {
            resize: vertical;
            min-height: 150px;
        }

        /* Tombol Kirim (Hijau) */
        .btn-submit {
            background-color: #2ed573;
            color: white;
            border: none;
            padding: 12px 35px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 30px;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #27ae60;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }
    </style>
@endpush

@section('content')
    <!-- Banner Judul Halaman -->
    <div class="page-header">
        <h1>Pengajuan Berita</h1>
    </div>

    <!-- Formulir Pengajuan -->
    <div class="form-container">
        @if(session('success'))
            <div style="padding: 15px; background-color: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('user.pengajuan.store') }}" method="POST">
            @csrf

            <!-- SECTION I -->
            <h3 class="section-title">I. Informasi Pengguna</h3>
            <div class="grid-3">
                <div>
                    <label class="form-label">1. Nama</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->nama_lengkap ?? 'AGAM YOGI PRASETYO' }}"
                        readonly>
                </div>
                <div>
                    <label class="form-label">2. NIM/NIK</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->nim_nik ?? '2211102281' }}" readonly>
                </div>
                <div>
                    <label class="form-label">3. Prodi/Unit</label>
                    <input type="text" class="form-control"
                        value="{{ Auth::user()->prodiUnit->nama_prodi_unit ?? 'S1 Teknik Informatika' }}" readonly>
                </div>
            </div>

            <!-- SECTION II -->
            <h3 class="section-title">II. Informasi Dasar Kegiatan</h3>
            <div style="margin-bottom: 20px;">
                <label class="form-label">1. Judul Berita atau Kegiatan</label>
                <input type="text" name="judul_berita" class="form-control"
                    placeholder="Masukkan judul berita atau kegiatan" required>
            </div>

            <div class="grid-2">
                <div>
                    <label class="form-label">2. Kategori Berita</label>
                    <select name="kategori_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriList as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">3. Tanggal Pelaksanaan</label>
                    <div class="date-range">
                        <input type="date" name="tanggal_mulai" class="form-control" required title="Tanggal Mulai">
                        <span style="font-weight: bold;"> - </span>
                        <input type="date" name="tanggal_selesai" class="form-control" required title="Tanggal Selesai">
                    </div>
                </div>
            </div>

            <!-- SECTION III -->
            <h3 class="section-title">III. Narasi Berita</h3>
            <div>
                <textarea name="narasi_berita" class="form-control"
                    placeholder="Jelaskan rincian kegiatan dan memuat unsur 5W+1H" required></textarea>
            </div>

            <!-- SECTION IV -->
            <h3 class="section-title">IV. Lampiran dan Kontak</h3>
            <div style="margin-bottom: 20px;">
                <label class="form-label">1. Link Dokumentasi (min. 3 Foto)</label>
                <input type="url" name="link_dokumentasi" class="form-control" placeholder="URL Drive" required>
            </div>
            <div>
                <label class="form-label">2. Kontak Person</label>
                <input type="text" name="kontak_person" class="form-control" placeholder="+628....." style="width: 50%;"
                    required>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn-submit">Kirim</button>

        </form>
    </div>
@endsection