<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penugasan Survei Siswa</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #eaeaea;
        }
        .logo {
            max-width: 150px;
            height: auto;
        }
        .headline {
            color: #2c3e50;
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .content {
            margin: 30px 0;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 15px;
        }
        .students-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .students-table th,
        .students-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .students-table th {
            background-color: #f2f2f2;
        }
        .students-table tr:hover {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #7f8c8d;
            border-top: 1px solid #eaeaea;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="headline">Penugasan Survei Calon Siswa Baru</h1>
        <h3>SMK INFORMATIKA UTAMA</h3>
    </div>

    <div class="content">
        <p class="greeting">Yth. {{ $surveyor->name }},</p>

        <p>Anda telah ditugaskan untuk melakukan survei terhadap beberapa siswa baru pada periode {{ $periode->tahun_periode ?? 'terkini' }}.</p>

        <p><strong>Berikut siswa yang akan anda survei:</strong></p>

        <table class="students-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>NISN</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student->registrasiPengambilan->nama }}</td>
                    <td>{{ $student->registrasiPengambilan->nisn }}</td>
                    <td>{{ $student->alamat }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p>Mohon untuk segera melakukan pendataan terhadap siswa-siswa tersebut sesuai prosedur yang telah ditetapkan.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/pendataan-surveyor-siswa') }}" style="background-color: #1abc9c; color: white; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold;">
                Buka Halaman Pendataan
            </a>
        </div>

    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Sistem Pendataan PPDB - SMK INFORMATIKA UTAMA</p>
    </div>
</body>
</html>
