@extends('layouts.app')

@section('content')
    <div class="mb-6 animate-fade-in-up">
        <a href="{{ route('admin.santri.index') }}" class="text-chalimi-600 hover:text-chalimi-800 mb-2 inline-block">← Kembali ke Data Santri</a>
        <h2 class="text-2xl font-bold text-chalimi-900">Import Data Santri (CSV)</h2>
    </div>

    <div class="glass-panel p-8 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <h4 class="font-bold text-yellow-800 mb-2">Petunjuk Import CSV</h4>
            <ul class="list-disc list-inside text-sm text-yellow-700 space-y-1">
                <li>Pastikan format CSV sesuai template.</li>
                <li>Urutan Kolom: <strong>Nama Lengkap, NIS, JK (L/P), Tempat Lahir, Tgl Lahir (YYYY-MM-DD), Alamat, Email Wali</strong></li>
                <li>Email Wali <strong>wajub sudah terdaftar</strong> di sistem User sebelumnya.</li>
                <li>Gunakan pemisah koma (,) atau titik koma (;) tergantung setting Excel region.</li>
            </ul>
        </div>

        <form action="{{ route('admin.santri.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-chalimi-700 mb-2">Upload File CSV</label>
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-chalimi-300 border-dashed rounded-lg cursor-pointer bg-white/30 hover:bg-white/50 transition">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-chalimi-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-chalimi-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                            <p class="text-xs text-chalimi-500">Separated Values (CSV)</p>
                        </div>
                        <input id="dropzone-file" name="csv_file" type="file" class="hidden" accept=".csv, .txt" required />
                    </label>
                </div>
                @error('csv_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-2 flex justify-end gap-3">
                <span class="text-xs text-chalimi-500 self-center mr-auto">Template CSV belum tersedia untuk download otomatis.</span>
                <button type="submit" class="btn-chalimi w-full md:w-auto shadow-lg shadow-emerald-500/30">
                    Proses Import
                </button>
            </div>
        </form>
    </div>
@endsection
