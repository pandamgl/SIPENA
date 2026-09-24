<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSO Login - Telkom University</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset bawaan browser */
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
            background-image: linear-gradient(rgba(168, 11, 16, 0.6), rgb(168, 11, 16)), url(https://smb.telkomuniversity.ac.id/wp-content/uploads/2025/12/Banner-Telkom-University-Kampus-Purwokerto_updated.jpg);
            background-size: cover;
            background-position: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 350px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .login-title {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #1a1a1a;
            letter-spacing: 1px;
        }

        /* Gaya Formulir */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #333;
        }

        .input-wrapper {
            position: relative;
        }

        /* Kolom Input Warna Merah */
        .form-input {
            width: 100%;
            padding: 12px 40px 12px 15px;
            background-color: #e51b24;

            color: white;
            border: none;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }

        /* Warna Teks Placeholder */
        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Posisi Ikon di dalam Kolom Input */
        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 16px;
        }

        /* Toggle Switch "Remember Me" */
        .remember-me-group {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 36px;
            height: 20px;
            margin-right: 10px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 14px;
            width: 14px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #e51b24;
        }

        input:checked+.slider:before {
            transform: translateX(16px);
        }

        .remember-label {
            font-size: 12px;
            color: #333;
            font-weight: 500;
        }

        /* Tombol Log In */
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #e51b24;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #c4151e;
        }
    </style>
</head>

<body>
    <div class="bg-container">
        <div class="login-card">
            <h2 class="login-title">LOGIN</h2>

            @if ($errors->any())
                <div
                    style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 12px; text-align: center;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-wrapper">
                        <input type="text" name="username" class="form-input" placeholder="Username"
                            value="{{ old('username') }}" required autofocus>
                        <!-- Ikon Profil -->
                        <i class="fa-regular fa-circle-user input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" class="form-input" placeholder="Password" required>
                        <!-- Ikon Gembok -->
                        <i class="fa-solid fa-lock input-icon"></i>
                    </div>
                </div>

                <div class="remember-me-group">
                    <label class="switch">
                        <input type="checkbox" name="remember" id="remember">
                        <span class="slider"></span>
                    </label>
                    <span class="remember-label">Remember me</span>
                </div>

                <button type="submit" class="btn-submit">
                    Log In <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</body>

</html>