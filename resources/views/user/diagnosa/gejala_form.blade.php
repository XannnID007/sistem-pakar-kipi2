@extends('layouts.app')

@section('content')
<style>
    .card {
        margin-top: 80px;
        border-radius: 12px;
    }

    .form-check-label {
        padding: 10px 15px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        cursor: pointer;
        display: block;
        margin-bottom: 10px;
        transition: background-color 0.3s, color 0.3s;
    }

    .form-check-input {
        /* input radio tetap ada, tapi disembunyikan visual */
        opacity: 0;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        margin: 0;
        cursor: pointer;
    }

    /* Warna aktif saat dipilih */
    .form-check-input:checked + .form-check-label {
        background-color: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }

    .step {
        animation: fadeIn 0.3s ease-in-out;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease-in-out;
    }

    .step.active {
        position: relative;
        opacity: 1;
        pointer-events: auto;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Buat pilihan jawaban vertikal */
    .btn-group-toggle {
        display: block !important;
    }

    .btn-group-toggle .btn {
        display: block;
        width: 100%;
        margin-bottom: 10px;
        text-align: left;
    }
</style>

<div class="container d-flex justify-content-center align-items-start">
    <div class="card shadow-sm p-4 w-100" style="max-width: 450px; position: relative; min-height: 180px;">
        <form method="POST" action="{{ route('diagnosa.proses') }}" id="formDiagnosa">
            @csrf
            <h5 class="text-center mb-4">Pilih Gejala yang Dialami</h5>

            <div id="stepContainer" style="position: relative;">
                @forelse($gejalas as $index => $gejala)
                    <div class="step {{ $index === 0 ? 'active' : '' }}">
                        <p><strong>{{ $index + 1 }}. Apakah anak Anda mengalami {{ $gejala->nama_gejala }}?</strong></p>

                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-outline-primary">
                                <input type="radio" name="gejala[{{ $gejala->kode_gejala }}][jawaban]" id="ya_{{ $gejala->kode_gejala }}" value="1.0" autocomplete="off"> Ya
                            </label>
                            <label class="btn btn-outline-primary">
                                <input type="radio" name="gejala[{{ $gejala->kode_gejala }}][jawaban]" id="ragu_{{ $gejala->kode_gejala }}" value="0.5" autocomplete="off"> Ragu-ragu
                            </label>
                            <label class="btn btn-outline-primary">
                                <input type="radio" name="gejala[{{ $gejala->kode_gejala }}][jawaban]" id="tidak_{{ $gejala->kode_gejala }}" value="0.0" autocomplete="off"> Tidak
                            </label>
                        </div>
                    </div>
                @empty
                    <p class="text-danger">Tidak ada data gejala.</p>
                @endforelse
            </div>

            <!-- Tidak perlu tombol submit karena otomatis submit -->
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentStep = 0;
    const steps = document.querySelectorAll('.step');
    const form = document.getElementById('formDiagnosa');

    function showStep(index) {
        steps.forEach((step, i) => {
            if (i === index) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });
    }

    function allAnswered() {
        let allAnsweredFlag = true;
        steps.forEach(step => {
            const radios = step.querySelectorAll('input[type="radio"]');
            const answered = Array.from(radios).some(radio => radio.checked);
            if (!answered) allAnsweredFlag = false;
        });
        return allAnsweredFlag;
    }

    function nextStep() {
        if (currentStep < steps.length - 1) {
            currentStep++;
            showStep(currentStep);
        }

        if (allAnswered()) {
            form.submit();
        }
    }

    steps.forEach(step => {
        const radios = step.querySelectorAll('input[type="radio"]');
        radios.forEach(radio => {
            radio.addEventListener('change', function () {
                nextStep();
            });
        });
    });

    showStep(currentStep);
});
</script>
@endsection
