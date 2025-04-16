<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            text-align: center;
            color: #2d3748;
        }

        .error-code {
            font-size: 7rem;
            font-weight: 700;
            line-height: 1;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 10px;
            letter-spacing: -2px;
        }

        .error-title {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1e293b;
        }

        .error-message {
            font-size: 1.2rem;
            margin-bottom: 5px;
            color: #64748b;
            max-width: 600px;
        }

        .home-button {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            margin-top: 0px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .home-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }

        dotlottie-player {
            width: 500px;
            height: 500px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 5rem;
            }

            .error-title {
                font-size: 1.8rem;
            }

            .error-message {
                font-size: 1rem;
            }

            dotlottie-player {
                width: 350px;
                height: 350px;
            }
        }

        @media (max-width: 480px) {
            dotlottie-player {
                width: 280px;
                height: 280px;
            }
        }
    </style>
</head>
<body>
    <div class="error-code">404</div>
    <h1 class="error-title">Halaman Tidak Ditemukan</h1>
    <p class="error-message">Sepertinya kamu tidak punya akses ke halaman ini.</p>

    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
    <dotlottie-player
        src="https://lottie.host/a7d5b061-b7fe-456b-bec8-1d3247b07707/hmDeijbKVP.lottie"
        background="transparent"
        speed="1"
        loop
        autoplay>
    </dotlottie-player>

    <a href="/" class="home-button">Kembali ke Beranda</a>
</body>
</html>
