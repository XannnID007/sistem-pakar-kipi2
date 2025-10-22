<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Sistem Pakar KIPI')</title>

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

    @yield('styles')
</head>

<body class="bg-slate-100 font-sans flex flex-col min-h-screen">

    <nav class="bg-white shadow-md fixed w-full z-30">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                {{-- Logo/Judul Kiri --}}
                <div class="flex-shrink-0">
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-700">
                        Sistem Pakar KIPI
                    </a>
                </div>

                {{-- Menu Kanan --}}
                <div class="flex items-center gap-4">
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center gap-3 text-left p-2 rounded-lg hover:bg-slate-100 transition-colors">
                                <div
                                    class="w-9 h-9 rounded-full bg-indigo-500 flex items-center justify-center text-white font-semibold text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="hidden md:inline font-medium text-slate-700">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-slate-500 text-xs transition-transform"
                                    :class="{ 'rotate-180': open }"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl z-40 origin-top-right overflow-hidden border border-slate-200">

                                <div class="px-4 py-3 border-b border-slate-200">
                                    <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
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
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-slate-700 hover:text-indigo-600">Login</a>
                        <a href="{{ route('register') }}"
                            class="text-sm font-medium text-white bg-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-700">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="w-full max-w-7xl mx-auto pt-28 pb-10 px-4 sm:px-6 lg:px-8 flex-1">
        @yield('content')
    </main>

    <footer class="bg-white text-center p-6 text-sm text-slate-500 mt-auto border-t border-slate-200">
        Sistem Pakar Diagnosa Gejala KIPI &copy; {{ date('Y') }}
    </footer>

    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> {{-- Masih ada script BS, bisa dihapus jika tidak ada komponen BS --}}
</body>

</html>
