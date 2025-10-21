<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar KIPI Batita</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="welcome-page">
    <!-- NAVBAR -->
    <div class="navbar">
        <div class="nav-links">
            <a href="#">Beranda</a>
            <a href="{{ route('login.form') }}">Login</a>
        </div>
    </div>

    <!-- HERO -->
    <div class="hero">
        <div class="judul">SISTEM PAKAR DIAGNOSA GEJALA KIPI PADA BATITA</div>
        <div class="subjudul">Menggunakan Metode Certainty Factor<br>Posyandu Melati</div>
        <a href="{{ route('login.form') }}" class="btn">Mulai Diagnosa</a>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        S1 Teknik Informatika <strong>STMIK Mardira Indonesia</strong>
    </div>
</body>
</html>
