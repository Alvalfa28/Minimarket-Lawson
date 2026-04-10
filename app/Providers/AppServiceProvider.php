<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate; // Import ini
use Illuminate\Support\ServiceProvider;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void { }

    public function boot(): void
    {
        // Gate untuk akses Data Barang (Admin & Gudang)
        Gate::define('access-barang', function (User $user) {
            return in_array($user->role, ['admin', 'gudang']);
        });

        // Gate untuk akses Peramalan (Admin & Manajer)
        Gate::define('access-peramalan', function (User $user) {
            return in_array($user->role, ['admin', 'manajer']);
        });

        // Gate untuk akses Laporan (Admin, Manajer, Kasir)
        Gate::define('access-laporan', function (User $user) {
            return in_array($user->role, ['admin', 'manajer', 'kasir']);
        });

        // Daftarkan observer untuk model PenjualanBulanan
        \App\Models\PenjualanBulanan::observe(\App\Observers\PenjualanObserver::class);
    }
}