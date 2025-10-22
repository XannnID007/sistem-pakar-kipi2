<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistem Pakar KIPI')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Segoe UI', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'slate': tailwind.colors.slate,
                        'indigo': tailwind.colors.indigo,
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-100 font-sans">

    <div class="{{ Auth::check() && Auth::user()->role == 'pakar' ? 'flex' : '' }}">

        @auth
            @if (Auth::user()->role == 'pakar')
                <aside class="w-64 bg-slate-900 text-slate-300 min-h-screen fixed shadow-2xl flex flex-col">

                    <div class="h-20 flex items-center px-6">
                        <h1 class="text-2xl font-bold text-white tracking-wide">
                            Pakar<span class="font-light">KIPI</span>
                        </h1>
                    </div>

                    <nav class="flex-1 px-4 py-2 space-y-2">
                        <a href="{{ url('dashboard/pakar') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                                  {{ request()->is('dashboard/pakar') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                            <i class="fas fa-home fa-fw w-5 text-center"></i>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('pakar.gejala.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                                  {{ request()->routeIs('pakar.gejala.*') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                            <i class="fas fa-stethoscope fa-fw w-5 text-center"></i>
                            <span>Kelola Gejala</span>
                        </a>

                        <a href="{{ route('pakar.kategori_kipi.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                                  {{ request()->routeIs('pakar.kategori_kipi.*') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                            <i class="fas fa-layer-group fa-fw w-5 text-center"></i>
                            <span>Kelola Kategori KIPI</span>
                        </a>

                        <a href="{{ route('pakar.aturan.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                                  {{ request()->routeIs('pakar.aturan.*') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                            <i class="fas fa-book-medical fa-fw w-5 text-center"></i>
                            <span>Kelola Aturan</span>
                        </a>

                        <a href="{{ route('pakar.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                                  {{ request()->routeIs('pakar.index') || request()->routeIs('pakar.create') || request()->routeIs('pakar.edit') || request()->routeIs('pakar.store') || request()->routeIs('pakar.update') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                            <i class="fas fa-user-md fa-fw w-5 text-center"></i>
                            <span>Kelola Pakar</span>
                        </a>

                        <a href="{{ route('pakar.riwayat.kipi') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                                  {{ request()->routeIs('pakar.riwayat.*') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                            <i class="fas fa-clipboard-list fa-fw w-5 text-center"></i>
                            <span>Data Diagnosa</span>
                        </a>

                        <a href="{{ route('laporan.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                                  {{ request()->routeIs('laporan.*') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-800 hover:text-white' }}">
                            <i class="fas fa-file-invoice fa-fw w-5 text-center"></i>
                            <span>Laporan</span>
                        </a>
                    </nav>

                </aside>
            @endif
        @endauth

        <div
            class="flex-1 flex flex-col min-h-screen {{ Auth::check() && Auth::user()->role == 'pakar' ? 'ml-64' : 'ml-0' }}">

            <header class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-30">
                <h2 class="text-2xl font-semibold text-slate-800">
                    @yield('page_title', 'Halaman')
                </h2>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center gap-3 text-left p-2 rounded-lg hover:bg-slate-100 transition-colors">
                        <div
                            class="w-9 h-9 rounded-full bg-indigo-500 flex items-center justify-center text-white font-semibold text-sm">
                            {{-- Inisial nama user --}}
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="hidden md:inline font-medium text-slate-700">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-slate-500 text-xs transition-transform"
                            :class="{ 'rotate-180': open }"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl z-40 origin-top-right overflow-hidden border border-slate-200">

                        <div class="px-4 py-3 border-b border-slate-200">
                            <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500">
                                {{ Auth::user()->email ?? 'Role: ' . Auth::user()->role }}
                            </p>
                        </div>

                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="flex items-center gap-3 w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                            <i class="fas fa-sign-out-alt fa-fw w-5 text-center"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-8 md:p-10">
                @yield('content')
            </main>

            <footer class="text-center p-6 text-slate-500 text-sm mt-auto">
                Sistem Pakar Diagnosa Gejala KIPI &copy; {{ date('Y') }}
            </footer>
        </div>

    </div>

    @stack('scripts')
</body>

</html>
