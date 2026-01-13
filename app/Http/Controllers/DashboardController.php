<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    /**
     * Dashboard for Admin
     */
    public function adminDashboard()
    {
        $totalSantri = Santri::aktif()->count();
        $totalPembayaran = Pembayaran::konfirmasi()->bulanIni()->sum('jumlah');
        // $totalTunggakan = ... (Complex query, placeholder for now)

        return view('admin.dashboard', compact('totalSantri', 'totalPembayaran'));
    }

    /**
     * Dashboard for Wali Santri
     */
    public function waliDashboard()
    {
        $user = auth()->user();
        $santriList = $user->santri()->with(['hafalan', 'tagihan'])->get();

        return view('wali.dashboard', compact('santriList'));
    }

    /**
     * Dashboard for Ustadz
     */
    public function ustadzDashboard()
    {
        $user = auth()->user();

        $countToday = $user->hafalanInput()
            ->whereDate('created_at', today())
            ->count();

        $countMonth = $user->hafalanInput()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $recentHafalan = $user->hafalanInput()
            ->with('santri')
            ->latest()
            ->take(5)
            ->get();

        return view('ustadz.dashboard', compact('countToday', 'countMonth', 'recentHafalan'));
    }

    /**
     * Dashboard for Pengurus
     */
    public function pengurusDashboard()
    {
        // 1. Pemasukan Hari Ini
        $pemasukanHariIni = \App\Models\Pembayaran::konfirmasi()
            ->whereDate('tanggal_bayar', today())
            ->sum('jumlah');

        // 2. Pemasukan Bulan Ini
        $pemasukanBulanIni = \App\Models\Pembayaran::konfirmasi()
            ->whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('jumlah');

        // 3. Tagihan Belum Lunas (Piutang)
        $totalPiutang = \App\Models\Tagihan::where('status', 'belum_lunas')
            ->sum('jumlah');

        // 4. Pembayaran Terbaru (5 Transaksi Terakhir)
        $recentPembayarans = \App\Models\Pembayaran::with(['santri', 'recordedBy'])
            ->latest()
            ->take(5)
            ->get();

        // 5. Pembayaran per Metode (Chart Data sederhana)
        $metodeStats = \App\Models\Pembayaran::konfirmasi()
            ->whereMonth('tanggal_bayar', now()->month)
            ->selectRaw('metode, sum(jumlah) as total')
            ->groupBy('metode')
            ->pluck('total', 'metode');

        return view('pengurus.dashboard', compact(
            'pemasukanHariIni', 
            'pemasukanBulanIni', 
            'totalPiutang', 
            'recentPembayarans',
            'metodeStats'
        ));
    }
}
