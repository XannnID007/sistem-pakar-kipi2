<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar KIPI Batita</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Poppins', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'slate': tailwind.colors.slate,
                        'indigo': tailwind.colors.indigo,
                    }
                }
            }
        }
    </script>

    {{-- Hapus <style> untuk animasi blob --}}
</head>

<body class="font-sans antialiased">

    <div class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden">

        {{-- 1. Latar Belakang Gambar --}}
        <div class="absolute inset-0 z-0 bg-cover bg-center"
            style="background-image: url('{{ asset('images/kipi.jpg') }}');">
        </div>

        {{-- 2. Lapisan Overlay Semi-Transparan --}}
        <div class="absolute inset-0 z-10 bg-black/60"></div> {{-- Opasitas 60% (bg-black/60) --}}

        {{-- Hapus div partikel --}}

        <nav class="absolute top-0 left-0 right-0 p-6 z-30"> {{-- Naikkan z-index --}}
            <div class="container mx-auto flex justify-between items-center px-4">
                <a href="#" class="text-white text-xl font-bold tracking-wide">PakarKIPI</a>
                <div class="space-x-6">
                    <a href="#"
                        class="text-white text-sm font-medium hover:text-indigo-200 transition-colors">Beranda</a>
                    <a href="{{ route('login.form') }}"
                        class="text-white text-sm font-medium hover:text-indigo-200 transition-colors">Login</a>
                </div>
            </div>
        </nav>

        <div class="relative z-20 text-center text-white px-6 py-20"> {{-- z-index 20 sudah cukup --}}
            <h1 class="text-4xl md:text-6xl font-bold uppercase tracking-wide drop-shadow-md"> {{-- Tambah drop-shadow --}}
                Sistem Pakar Diagnosa Gejala KIPI
            </h1>
            <p class="text-lg md:text-2xl font-light mt-4 mb-2 drop-shadow-sm">
                Menggunakan Metode Certainty Factor
            </p>
            <p class="text-lg md:text-2xl font-semibold text-indigo-200 drop-shadow-sm">
                Posyandu Melati
            </p>

            <a href="{{ route('login.form') }}"
                class="inline-block mt-12 px-10 py-4 bg-white text-indigo-700 font-bold text-lg rounded-full shadow-lg 
                      transform hover:scale-105 hover:bg-indigo-50 transition-all duration-300">
                Mulai Diagnosa
            </a>
        </div>

        <footer class="absolute bottom-0 p-6 text-center text-indigo-200 text-sm z-30 w-full"> {{-- Naikkan z-index --}}
            S1 Teknik Informatika <strong>STMIK Mardira Indonesia</strong>
        </footer>
    </div>
</body>

</html>
