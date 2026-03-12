<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Forbidden' }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f8fafc;
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
            max-width: 580px;
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.08);
            padding: 36px 28px;
            text-align: center;
        }

        h1 {
            margin: 0 0 12px;
            font-size: 30px;
            color: #b91c1c;
        }

        p {
            margin: 0 auto 24px;
            max-width: 460px;
            color: #475569;
            line-height: 1.7;
            font-size: 15px;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            border: none;
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #0f172a;
        }

        form {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <h1>Access Forbidden</h1>

            <p>
                Akun Anda berhasil login ke SSO, tetapi tidak memiliki izin untuk mengakses aplikasi ini.
                Silakan keluar dari aplikasi lalu login ulang menggunakan akun yang memiliki group yang benar.
            </p>

            <div class="actions">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Keluar dari Aplikasi</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
