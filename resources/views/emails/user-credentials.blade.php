<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Informasi Akun PPDB SMKIU</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .content {
            padding: 20px 0;
        }
        .credentials {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .verification-info {
            margin-top: 20px;
            padding: 10px;
            background-color: #e8f4fe;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            font-size: 0.8em;
            color: #777;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Selamat Datang di Aplikasi Pendataan PPDB SMKIU! &#128513;</h2>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $name }}</strong>,</p>

            <p>Akun anda telah berhasil dibuat. Berikut adalah informasi login anda:</p>

            <div class="credentials">
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
            </div>

            <div class="verification-info">
                @if($verified)
                    <p><strong>Status Email:</strong> Terverifikasi</p>
                    <p>Email Anda telah diverifikasi secara otomatis. Anda dapat langsung login ke sistem.</p>
                @else
                    <p><strong>Status Email:</strong> Belum Terverifikasi</p>
                    <p>Anda perlu melakukan verifikasi email sebelum bisa menggunakan semua fitur.
                       Silahkan periksa inbox Anda untuk link verifikasi email.</p>
                @endif
            </div>

            <p>Silahkan login menggunakan kredensial di atas melalui website PPDB SMKIU. Kami menyarankan untuk segera mengubah password anda setelah berhasil login untuk alasan keamanan.</p>

            <p>Jika anda memiliki pertanyaan, silahkan hubungi administrator.</p>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon untuk tidak membalas.</p>
            <p>&copy; {{ date('Y') }} Sistem Pendataan PPDB - SMK INFORMATIKA UTAMA</p>
        </div>
    </div>
</body>
</html>
