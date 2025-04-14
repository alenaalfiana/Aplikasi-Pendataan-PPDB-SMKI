<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penerimaan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        img.logo { height: 50px; }
    </style>
</head>
<body>

    <table width="100%">
        <tr>
            <td align="center">
                <h2>Laporan Penerimaan Siswa </h2>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NISN</th>
                <th>Asal Sekolah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->formPendaftaran->registrasiPengambilan->nama ?? '-' }}</td>
                    <td>{{ $item->formPendaftaran->nisn ?? '-' }}</td>
                    <td>{{ $item->formPendaftaran->asal_sekolah ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
