<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verifikasi Email</title>
    </head>

    <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
            style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
            <tr>
                <td style="padding: 20px 0; text-align: center; background-color: #b5d1ec;">
                    <img src="https://i.imgur.com/OuezcgU.png" alt="Logo Sekolah" class="logo"
                        style="max-width: 150px; height: auto;">
                </td>
            </tr>
            <tr>
                <td style="padding: 40px 30px;">
                    <h1 style="color: #1e90ff; font-size: 24px; margin-bottom: 20px;">Verifikasi Alamat Email-mu!</h1>
                    <p style="color: #333333; font-size: 16px; line-height: 1.5;">
                        Terimakasih telah mendaftar! Silahkan klik tombol dibawah untuk memverifikasi email dan mulai
                        mengaktifkan akunmu.</p>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                        style="margin-top: 30px; margin-bottom: 30px;">
                        <tr>
                            <td align="center">
                                <a href="{{ $url }}"
                                    style="display: inline-block; padding: 12px 24px; background-color: #1e90ff; color: #ffffff; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;">Verifikasi
                                </a>
                            </td>
                        </tr>
                    </table>
                    <p style="color: #666666; font-size: 14px; line-height: 1.5;">Jika kamu tidak merasa membuat akun,
                        abaikan pesan ini.</p>
                </td>
            </tr>
            <tr>
                <td
                    style="padding: 20px 30px; background-color: #f0f8ff; text-align: center; color: #666666; font-size: 14px;">
                    <p>&copy; {{ date('Y') }} Sistem Pendataan PPDB - SMK INFORMATIKA UTAMA</p>
                </td>
            </tr>
        </table>
    </body>

</html>
