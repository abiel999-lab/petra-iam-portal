<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Logged Out' }}</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f1f5f9;
            color: #0f172a;
        }
        .wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .card {
            width: 100%;
            max-width: 560px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 18px 50px rgba(0,0,0,.08);
            padding: 38px 28px;
            text-align: center;
        }
        h1 {
            margin: 0 0 14px;
            font-size: 32px;
        }
        p {
            margin: 0 auto 24px;
            max-width: 430px;
            color: #475569;
            line-height: 1.7;
        }
        .btn {
            display: inline-block;
            text-decoration: none;
            background: #2563eb;
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 700;
        }
        .hint {
            margin-top: 18px;
            color: #64748b;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <h1>Berhasil Logout</h1>
            <p>
                Session portal sudah dihapus. Untuk keamanan, Anda akan tetap berada di halaman ini
                sampai memilih untuk memulai session baru.
            </p>

            <a href="{{ route('session.start') }}" class="btn">Login Lagi</a>

            <div class="hint">
                Refresh, membuka tab baru, atau mengetik domain utama akan tetap mengarah ke halaman ini.
            </div>
        </div>
    </div>

    <script>
        try {
            localStorage.setItem('portal_logged_out', '1');
        } catch (e) {}
    </script>
</body>
</html>
