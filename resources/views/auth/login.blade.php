<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lawson RSUD Sayang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background-color: #0057A8;
            background-image: 
                radial-gradient(at 0% 0%, rgba(0, 87, 168, 0.5) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(232, 0, 27, 0.15) 0px, transparent 50%),
                url("https://www.transparenttextures.com/patterns/cubes.png"); 
            display: flex; 
            align-items: center; 
            justify-content: center;
            height: 100vh; 
            margin: 0;
            font-family: 'Inter', sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
            z-index: 10;
        }

        .card { 
            border: 1px solid rgba(255, 255, 255, 0.2); 
            border-radius: 30px; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); 
            background: rgba(255, 255, 255, 0.98);
            overflow: hidden;
        }

        .card-header-blue {
            padding: 40px 20px 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .lawson-logo {
            width: 100px;
            height: auto;
            margin-bottom: 20px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
            display: block;
        }

        .logo-text { 
            color: #0057A8; 
            font-weight: 800; 
            font-size: 28px; 
            letter-spacing: -1px;
            margin-bottom: 0;
            text-transform: uppercase;
        }

        .logo-text span { color: #E8001B; }

        /* Style untuk Alert Error */
        .alert-error {
            background-color: #FFF5F5;
            border-left: 4px solid #E8001B;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        .form-control {
            border-radius: 14px;
            padding: 14px 18px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(0, 87, 168, 0.1);
            border-color: #0057A8;
            background-color: #ffffff;
        }

        .btn-lawson { 
            background: linear-gradient(135deg, #E8001B 0%, #b30015 100%);
            color: white; 
            border: none; 
            border-radius: 14px;
            padding: 15px;
            font-weight: 700;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-lawson:hover { 
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(232, 0, 27, 0.3);
            color: white;
        }

        .footer-text {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            margin-top: 25px;
        }

        .fade-in {
            animation: fadeInBlur 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeInBlur {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="login-container fade-in">
        <div class="card shadow-2xl">
            <div class="card-header-blue">
                <img src="{{ asset('img/lawson.png') }}" alt="Lawson Logo" class="lawson-logo">
                <div class="logo-text">LAWSON <span>SIM</span></div>
                <div class="mt-1 text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">
                    INVENTORI RSUD SAYANG
                </div>
            </div>
            
            <div class="card-body p-4 pt-2">
                
                {{-- BAGIAN PESAN ERROR --}}
                @if(session()->has('error'))
                    <div class="alert-error">
                        <div style="font-size: 20px; margin-right: 12px;">🚫</div>
                        <div>
                            <div style="color: #9B2C2C; font-weight: 800; font-size: 13px;">LOGIN GAGAL</div>
                            <div style="color: #C53030; font-size: 11px;">{{ session('error') }}</div>
                        </div>
                    </div>
                @endif

                <form action="/login" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Email</label>
                        {{-- Ditambahkan value="{{ old('email') }}" agar email tidak hilang saat salah --}}
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="admin@lawson.com" required autofocus>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-secondary">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" class="btn btn-lawson w-100">
                        LOGIN KE SISTEM
                    </button>
                </form>
            </div>
        </div>
        <div class="footer-text">
            &copy; 2026 RSUD Sayang Cianjur &bull; Lawson Station
        </div>
    </div>
</body>
</html>