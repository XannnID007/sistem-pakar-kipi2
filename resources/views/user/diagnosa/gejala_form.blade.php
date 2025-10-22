@extends('layouts.app')

@section('title', 'Mulai Diagnosa - Sistem Pakar KIPI')

@section('styles')
    {{-- Hapus <style> block, semua styling sekarang ada di body --}}
@endsection

@section('content')
    <div class="flex justify-center py-12">
        {{-- Card Utama --}}
        <div class="w-full max-w-lg bg-white p-8 rounded-3xl shadow-xl border border-slate-100 mx-auto">
            <form method="POST" action="{{ route('diagnosa.proses') }}" id="formDiagnosa">
                @csrf
                <h5 class="text-xl font-bold text-slate-800 text-center mb-6 pb-4 border-b border-slate-200">
                    Pilih Gejala yang Dialami
                </h5>

                {{-- Kontainer untuk step-step pertanyaan --}}
                <div id="stepContainer" class="relative min-h-[280px]"> {{-- Beri tinggi minimum agar card tidak melompat --}}

                    @forelse($gejalas as $index => $gejala)
                        <div
                            class="step transition-all duration-300 ease-in-out 
                                {{-- Step pertama aktif, yang lain tersembunyi --}}
                                {{ $index === 0 ? 'opacity-100 relative pointer-events-auto' : 'opacity-0 absolute inset-0 pointer-events-none' }}">

                            {{-- Pertanyaan --}}
                            <p class="text-lg font-medium text-slate-800 mb-6 text-center">
                                <strong class="text-indigo-600">{{ $index + 1 }}.</strong>
                                Apakah anak Anda mengalami <strong>{{ $gejala->nama_gejala }}</strong>?
                            </p>

                            {{-- Pilihan Jawaban (Custom Radio with Tailwind) --}}
                            <div class="space-y-4">

                                {{-- Pilihan "Ya" --}}
                                <div class="relative">
                                    <input type="radio" name="gejala[{{ $gejala->kode_gejala }}][jawaban]"
                                        id="ya_{{ $gejala->kode_gejala }}" value="1.0"
                                        class="absolute opacity-0 w-full h-full inset-0 cursor-pointer peer">
                                    <label for="ya_{{ $gejala->kode_gejala }}"
                                        class="block w-full text-center px-4 py-3 border-2 border-slate-300 rounded-lg text-slate-700 font-medium transition-colors duration-200 
                                              peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 hover:border-indigo-400">
                                        Ya
                                    </label>
                                </div>

                                {{-- Pilihan "Ragu-ragu" --}}
                                <div class="relative">
                                    <input type="radio" name="gejala[{{ $gejala->kode_gejala }}][jawaban]"
                                        id="ragu_{{ $gejala->kode_gejala }}" value="0.5"
                                        class="absolute opacity-0 w-full h-full inset-0 cursor-pointer peer">
                                    <label for="ragu_{{ $gejala->kode_gejala }}"
                                        class="block w-full text-center px-4 py-3 border-2 border-slate-300 rounded-lg text-slate-700 font-medium transition-colors duration-200 
                                              peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 hover:border-indigo-400">
                                        Ragu-ragu
                                    </label>
                                </div>

                                {{-- Pilihan "Tidak" --}}
                                <div class="relative">
                                    <input type="radio" name="gejala[{{ $gejala->kode_gejala }}][jawaban]"
                                        id="tidak_{{ $gejala->kode_gejala }}" value="0.0"
                                        class="absolute opacity-0 w-full h-full inset-0 cursor-pointer peer">
                                    <label for="tidak_{{ $gejala->kode_gejala }}"
                                        class="block w-full text-center px-4 py-3 border-2 border-slate-300 rounded-lg text-slate-700 font-medium transition-colors duration-200 
                                              peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 hover:border-indigo-400">
                                        Tidak
                                    </label>
                                </div>

                            </div>
                        </div>
                    @empty
                        <p class="text-center text-red-600">Tidak ada data gejala yang tersedia.</p>
                    @endforelse
                </div>

            </form>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Script telah dimodifikasi untuk mentransisikan kelas Tailwind --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 0;
            const steps = document.querySelectorAll('.step');
            const form = document.getElementById('formDiagnosa');
            const totalSteps = steps.length;

            // Fungsi untuk menampilkan step berdasarkan index
            function showStep(index) {
                steps.forEach((step, i) => {
                    // Hapus semua kelas transisi
                    step.classList.remove('opacity-100', 'relative', 'pointer-events-auto');
                    step.classList.remove('opacity-0', 'absolute', 'inset-0', 'pointer-events-none');

                    if (i === index) {
                        // Tampilkan step yang aktif
                        step.classList.add('opacity-100', 'relative', 'pointer-events-auto');
                    } else {
                        // Sembunyikan step yang tidak aktif
                        step.classList.add('opacity-0', 'absolute', 'inset-0', 'pointer-events-none');
                    }
                });
            }

            // Fungsi untuk mengecek apakah semua pertanyaan sudah dijawab
            function allAnswered() {
                let allAnsweredFlag = true;
                steps.forEach(step => {
                    const radios = step.querySelectorAll('input[type="radio"]');
                    // Cek apakah ada radio button di step ini yang ter-check
                    const answered = Array.from(radios).some(radio => radio.checked);
                    if (!answered) {
                        allAnsweredFlag = false;
                    }
                });
                return allAnsweredFlag;
            }

            // Fungsi untuk pindah ke step berikutnya
            function nextStep() {
                // Cek dulu apakah semua sudah terjawab
                if (allAnswered()) {
                    // Jika ya, submit form
                    form.submit();
                    return; // Hentikan eksekusi
                }

                // Jika belum semua terjawab, cari step berikutnya yang belum dijawab
                let nextUnansweredStep = (currentStep + 1) % totalSteps;

                // Loop untuk mencari step berikutnya yang belum dijawab
                while (nextUnansweredStep !== currentStep) {
                    const radios = steps[nextUnansweredStep].querySelectorAll('input[type="radio"]');
                    const answered = Array.from(radios).some(radio => radio.checked);

                    if (!answered) {
                        currentStep = nextUnansweredStep;
                        showStep(currentStep);
                        return; // Tampilkan step yang belum dijawab dan berhenti
                    }

                    nextUnansweredStep = (nextUnansweredStep + 1) % totalSteps;
                }

                // Jika loop selesai dan kembali ke step awal (artinya semua sudah terjawab)
                if (allAnswered()) {
                    form.submit();
                }
            }

            // Tambahkan event listener ke semua radio button
            steps.forEach((step, index) => {
                const radios = step.querySelectorAll('input[type="radio"]');
                radios.forEach(radio => {
                    // Gunakan event 'click' atau 'change'
                    radio.addEventListener('change', function() {
                        // Beri sedikit jeda agar animasi radio button terlihat
                        setTimeout(() => {
                            nextStep();
                        }, 200); // 200ms
                    });
                });
            });

            // Tampilkan step pertama saat halaman dimuat
            showStep(currentStep);
        });
    </script>
@endsection
