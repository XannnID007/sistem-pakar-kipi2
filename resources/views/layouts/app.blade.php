<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sistem Pakar KIPI</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @yield('styles')
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f9ff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: rgb(21, 140, 156);
            padding: 6px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }

        .nav-left {
            font-weight: bold;
            font-size: 18px;
            color: white;
        }

        .nav-right a,
        .nav-right button {
            color: white;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
            background: none;
            border: none;
        }

        .nav-right a:hover {
            color: #b2e0e5;
        }

        /* Main */
        main {
            margin-top: 80px; /* sesuaikan dengan tinggi nav */
            padding: 20px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        .container-dashboard {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                flex-wrap: wrap; /* izinkan teks turun baris jika terlalu panjang */
            }

            .welcome {
                flex: 1 1 auto;      /* fleksibel */
                min-width: 200px;    /* jangan terlalu kecil */
                white-space: normal; /* izinkan teks membungkus */
            }


            .illustration {
                flex: 1;
                display: flex;
                justify-content: flex-end; /* gambar ke kanan */
            }

            .illustration img {
                max-width: 350px;
                height: auto;
            }


        /* Menu */
        .menu {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .menu a {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 200px;
            padding: 10px 6px;
            background: white;
            border: 2px solid #2563eb;
            border-radius: 15px;
            text-decoration: none;
            color: #222;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }

        .menu a:hover {
            background-color: #2563eb;
            color: white;
            transform: translateY(-5px);
        }

        .menu-icon {
            font-size: 40px;
            margin-bottom: 12px;
        }

        /* Footer */
        footer {
            background-color: rgb(21, 140, 156);
            color: white;
            padding: 10px 0;
            text-align: center;
            font-size: 14px;
            margin-top: auto;
        }
    </style>
</head>
@yield('scripts')
<body>

<nav>
    <div class="nav-left">
        Sistem Pakar KIPI
    </div>
    <<div class="nav-right">
    @auth
        <span class="me-3 text-white">{{ Auth::user()->name }}</span>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-sm btn-light">Logout</button>
        </form>
    @endauth
</div>

</nav>

<main>
    @yield('content')
</main>

<footer>
    Sistem Pakar Diagnosa Gejala KIPI &copy; 2025
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
