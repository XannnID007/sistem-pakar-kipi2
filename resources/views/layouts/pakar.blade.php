<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistem Pakar KIPI')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background-color: #f4f6f9;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 220px;
            background-color: rgb(21, 140, 156);
            color: white;
            position: fixed;
            top: 0;
            bottom: 0;
            padding: 20px 0;
        }

        .sidebar h4 {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 60px;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #1f2d3d;
        }

        .sidebar i {
            margin-right: 10px;
        }

        .main-content {
            margin-left: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: 100%;
        }

        .with-sidebar .main-content {
            margin-left: 220px;
            width: calc(100% - 220px);
        }

        .topbar {
            background-color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        .content {
            padding: 30px;
            flex: 1;
        }

        .card-box {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 20px;
            background-color: white;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .card-box i {
            font-size: 30px;
            color: #3c8dbc;
        }

        footer {
            background-color: white;
            color: black;
            padding: 12px;
            text-align: center;
            margin-top: auto;
        }
    </style>
</head>

<body>

    <div class="wrapper {{ Auth::check() && Auth::user()->role == 'pakar' ? 'with-sidebar' : '' }}">

        @auth
            @if (Auth::user()->role == 'pakar')
                <div class="sidebar">
                    <h4></h4>
                    <h4></h4>
                    <a href="{{ url('dashboard/pakar') }}" class="{{ request()->is('dashboard/pakar') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>

                    <a href="{{ route('pakar.gejala.index') }}"
                        class="{{ request()->routeIs('pakar.gejala.*') ? 'active' : '' }}">
                        <i class="fas fa-stethoscope"></i> Gejala
                    </a>

                    <a href="{{ route('pakar.kategori_kipi.index') }}"
                        class="{{ request()->routeIs('pakar.kategori_kipi.*') ? 'active' : '' }}">
                        <i class="fas fa-layer-group"></i> Kategori KIPI
                    </a>

                    <a href="{{ route('pakar.aturan.index') }}"
                        class="{{ request()->routeIs('pakar.aturan.*') ? 'active' : '' }}">
                        <i class="fas fa-book-medical"></i> Aturan

                    </a>

                    <a href="{{ route('pakar.riwayat.kipi') }}"
                        class="{{ request()->routeIs('pakar.riwayat.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i> Data Diagnosa
                    </a>

                    <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i> Laporan
                    </a>

                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            @endif
        @endauth

        {{-- ... bagian atas tetap sama --}}

        <div class="main-content">
            <div class="topbar d-flex justify-content-between align-items-center px-3 py-2">
                <div><strong>Sistem Pakar KIPI</strong></div>

                <div class="d-flex align-items-center gap-3">
                    {{-- Hapus lonceng notifikasi --}}
                    {{-- Nama User --}}
                    @auth
                        <span>{{ Auth::user()->name }}</span>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                    @endauth
                </div>
            </div>

            <div class="content">
                @yield('content')
            </div>

            <footer>
                Sistem Pakar Diagnosa Gejala KIPI &copy; 2025
            </footer>
        </div>

    </div>

</body>

</html>
