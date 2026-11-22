<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\LogAksiAdmin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View Composer untuk inject notifikasi status perubahan ke semua view user
        View::composer(['layouts.user', 'user.*'], function ($view) {
            $userId = Auth::id() ?? 1;
            try {
                $userNotifications = LogAksiAdmin::whereHas('pengajuan', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->with('pengajuan')
                ->latest('id')
                ->take(15)
                ->get();

                $view->with('userNotifications', $userNotifications);
                $view->with('latestNotification', $userNotifications->first());
            } catch (\Throwable $e) {
                $view->with('userNotifications', collect());
                $view->with('latestNotification', null);
            }
        });
    }
}
