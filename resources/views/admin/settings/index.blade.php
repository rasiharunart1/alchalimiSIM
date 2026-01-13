@extends('layouts.app')

@section('content')
<div class="mb-6 animate-fade-in-up">
    <h2 class="text-2xl font-bold text-chalimi-900">Pengaturan Sekolah</h2>
    <p class="text-chalimi-600">Konfigurasi umum sistem informasi manajemen.</p>
</div>

<div class="flex flex-col md:flex-row gap-6 animate-fade-in-up" style="animation-delay: 0.1s">
    <div class="w-full md:w-1/2">
        <div class="glass-panel p-6">
            <h3 class="text-lg font-bold text-chalimi-800 mb-4 border-b border-chalimi-100 pb-2">
                <i class="fa-solid fa-calendar-days mr-2"></i> Tahun Ajaran & Akademik
            </h3>
            
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Tahun Ajaran Aktif</label>
                    <input type="text" name="tahun_ajaran_aktif" value="{{ $settings['tahun_ajaran_aktif'] ?? '2024/2025' }}" 
                        class="w-full glass-input" placeholder="Contoh: 2024/2025">
                    <p class="text-xs text-chalimi-500 mt-1">Digunakan sebagai default untuk pembayaran dan input hafalan baru.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Status PSB (Penerimaan Santri Baru)</label>
                    <select name="psb_active" class="w-full glass-input text-chalimi-800">
                        <option value="1" {{ ($settings['psb_active'] ?? '0') == '1' ? 'selected' : '' }}>Dibuka (Aktif)</option>
                        <option value="0" {{ ($settings['psb_active'] ?? '0') == '0' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                    <p class="text-xs text-chalimi-500 mt-1">Jika ditutup, formulir pendaftaran tidak dapat diakses publik.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Nominal SPP Bulanan (Default)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-chalimi-500">Rp</span>
                        <input type="number" name="biaya_spp_bulanan" value="{{ $settings['biaya_spp_bulanan'] ?? '150000' }}" 
                            class="w-full glass-input pl-10" placeholder="150000">
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="btn-chalimi shadow-lg shadow-emerald-500/30">
                        💾 Simpan Pengaturan
                    </button>
                </div>
            
            <h3 class="text-lg font-bold text-chalimi-800 mt-8 mb-4 border-b border-chalimi-100 pb-2">
                <i class="fa-solid fa-desktop mr-2"></i> Konfigurasi Landing Page
            </h3>

            <!-- Form continues -->
                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Judul Utama (Welcome Title)</label>
                    <input type="text" name="welcome_title" value="{{ $settings['welcome_title'] ?? 'Membangun Generasi' }}" 
                        class="w-full glass-input" placeholder="Membangun Generasi">
                </div>

                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Sub-Judul (Welcome Subtitle)</label>
                    <input type="text" name="welcome_subtitle" value="{{ $settings['welcome_subtitle'] ?? "Qur'ani & Berakhlak" }}" 
                        class="w-full glass-input" placeholder="Qur'ani & Berakhlak">
                </div>

                <div>
                    <label class="block text-sm font-medium text-chalimi-700 mb-1">Deskripsi Singkat</label>
                    <textarea name="welcome_description" rows="3" class="w-full glass-input">{{ $settings['welcome_description'] ?? 'Sistem terintegrasi untuk memantau hafalan santri...' }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Username Instagram</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-chalimi-500">@</span>
                            <input type="text" name="instagram_username" value="{{ $settings['instagram_username'] ?? '' }}" 
                                class="w-full glass-input pl-8" placeholder="username_pondok">
                        </div>
                    </div>
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-chalimi-700">Link Gallery Instagram (Tampil 5 Foto Teratas)</label>
                    <div class="grid grid-cols-1 gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-xs text-chalimi-400 font-bold">{{ $i }}</span>
                                <input type="url" name="ig_link_{{ $i }}" value="{{ $settings['ig_link_'.$i] ?? '' }}" 
                                    class="w-full glass-input pl-8 text-xs" placeholder="https://www.instagram.com/p/...">
                            </div>
                        @endfor
                    </div>
                    <p class="text-[10px] text-chalimi-500 italic mt-1">
                        *Sistem akan mencoba mengambil gambar otomatis dari link post yang Anda masukkan.
                    </p>
                </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="btn-chalimi shadow-lg shadow-emerald-500/30">
                        💾 Simpan Konten
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="w-full md:w-1/2">
        <div class="glass-panel p-6 bg-chalimi-900 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 p-32 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
            
            <h3 class="text-lg font-bold mb-4 relative z-10 border-b border-white/20 pb-2">Informasi Sistem</h3>
            
            <div class="space-y-4 relative z-10 text-chalimi-100 text-sm">
                <p>Pengaturan ini berdampak global pada sistem. Pastikan data yang dimasukkan benar.</p>
                
                <ul class="list-disc list-inside space-y-2">
                    <li><b>Tahun Ajaran Aktif</b> akan otomatis terisi pada form pembayaran SPP.</li>
                    <li><b>Status PSB</b> mengontrol akses menu pendaftaran di halaman depan.</li>
                    <li><b>Biaya SPP</b> menjadi acuan generate tagihan bulanan otomatis (masa depan).</li>
                </ul>

                <div class="mt-8 p-4 bg-white/10 rounded-xl border border-white/10">
                    <p class="font-bold text-white mb-1"><i class="fa-solid fa-triangle-exclamation"></i> Zona Bahaya</p>
                    <p class="text-xs text-chalimi-200 mb-3">Reset data sistem (Hanya untuk debugging).</p>
                    <!-- Future implementation -->
                    <button disabled class="px-3 py-1 bg-red-500/50 text-white/50 rounded text-xs cursor-not-allowed">Reset Database</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
