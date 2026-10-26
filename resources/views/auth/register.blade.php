<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIPENA Telkom University</title>

    <!-- Memanggil Library Ikon dari FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Reset bawaan browser */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            height: 100%;
        }

        /* Latar Belakang & Efek Filter Merah */
        .bg-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: linear-gradient(rgba(229, 27, 36, 0.6), rgba(229, 27, 36, 0.85)), url('https://smb.telkomuniversity.ac.id/wp-content/uploads/2025/12/Banner-Telkom-University-Kampus-Purwokerto_updated.jpg');
            background-size: cover;
            background-position: center;
            padding: 20px;
        }

        /* Kotak Registrasi (Glassmorphism Effect) */
        .register-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        /* Gaya Formulir */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #1a1a1a;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        /* Kolom Input dengan Border Merah (Sesuai Mockup Register) */
        .form-input {
            width: 100%;
            padding: 12px 40px 12px 15px;
            background-color: rgba(255, 255, 255, 0.6);
            border: 2px solid #e51b24;
            border-radius: 6px;
            font-size: 14px;
            color: #333;
            font-family: inherit;
            outline: none;
            transition: background-color 0.3s;
        }

        .form-input:focus {
            background-color: #ffffff;
        }

        .form-input::placeholder {
            color: #888;
        }

        /* Khusus untuk elemen Select (Prodi/Unit) */
        select.form-input {
            appearance: none;
            cursor: pointer;
            padding-right: 40px;
        }

        /* Posisi Ikon di dalam Kolom Input (Untuk Dropdown & Password) */
        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #555;
            font-size: 16px;
            cursor: pointer;
            user-select: none;
            transition: color 0.2s ease;
        }

        .input-icon:hover {
            color: #e51b24;
        }

        /* Tombol Register */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background-color: #e51b24;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 30px;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #c4151e;
        }

        /* Footer Link */
        .form-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            color: #333;
        }

        .form-footer a {
            color: #1a1a1a;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.3s;
        }

        .form-footer a:hover {
            color: #e51b24;
        }
    </style>
</head>

<body>
    <div class="bg-container">
                <div class="register-card">

            @if ($errors->any())
                <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 13px;">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Registrasi Laravel -->
            <form action="{{ route('register.proses') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <input type="text" name="nama" class="form-input" placeholder="Masukkan nama lengkap" value="{{ old('nama') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">NIM/NIK</label>
                    <div class="input-wrapper">
                        <input type="text" name="nim_nik" class="form-input" placeholder="Masukkan NIM/NIK" value="{{ old('nim_nik') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Prodi / Unit</label>
                    <div class="input-wrapper">
                        <select name="prodi_unit_id" class="form-input" required>
                            <option value="" disabled {{ old('prodi_unit_id') ? '' : 'selected' }}>Pilih prodi / unit</option>
                            @if(isset($prodiList) && $prodiList->count() > 0)
                                @foreach($prodiList as $p)
                                    <option value="{{ $p->id }}" {{ old('prodi_unit_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_prodi_unit }}
                                    </option>
                                @endforeach
                            @else
                                <option value="1" {{ old('prodi_unit_id') == 1 ? 'selected' : '' }}>S1 Teknik Informatika</option>
                                <option value="6" {{ old('prodi_unit_id') == 6 ? 'selected' : '' }}>S1 Rekayasa Perangkat Lunak</option>
                                <option value="4" {{ old('prodi_unit_id') == 4 ? 'selected' : '' }}>S1 Data Sains</option>
                                <option value="3" {{ old('prodi_unit_id') == 3 ? 'selected' : '' }}>Humas / Internal</option>
                            @endif
                        </select>
                        <i class="fa-solid fa-chevron-down input-icon" style="pointer-events: none;"></i>
                    </div>
                </div>

                <!-- Input Username Baru -->
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-wrapper">
                        <input type="text" name="username" class="form-input" placeholder="Masukkan username" value="{{ old('username') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" class="form-input" placeholder="Masukkan email" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="password" class="form-input"
                            placeholder="Masukkan password" required>
                        <i class="fa-solid fa-eye input-icon" onclick="togglePassword('password', this)"
                            title="Tampilkan password"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password_confirmation" id="password_confirm" class="form-input"
                            placeholder="Masukkan konfirmasi password" required>
                        <i class="fa-solid fa-eye input-icon" onclick="togglePassword('password_confirm', this)"
                            title="Tampilkan password"></i>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Register <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </button>

                <div class="form-footer">
                    Sudah punya akun? <a href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Interaktif untuk Toggle Password Visibility -->
    <script>
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (!input) return;

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
                icon.setAttribute("title", "Sembunyikan password");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
                icon.setAttribute("title", "Tampilkan password");
            }
        }
    </script>
</body>

</html>
