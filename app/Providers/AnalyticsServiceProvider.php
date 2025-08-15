<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

// [PERBAIKAN] Impor kelas yang benar untuk membuat filter GA4
use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\Filter\StringFilter;
use Google\Analytics\Data\V1beta\Filter\StringFilter\MatchType;
use Google\Analytics\Data\V1beta\FilterExpression;

class AnalyticsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['layouts.app', 'dashboard.superadmin'], function ($view) {
            $defaultStats = [
                'online' => 'N/A',
                'today' => 'N/A',
                'total' => 'N/A'
            ];

            if (!config('analytics.property_id') || !file_exists(config('analytics.service_account_credentials_json'))) {
                Log::warning('Google Analytics tidak terkonfigurasi.');
                $view->with('visitorStats', $defaultStats);
                return;
            }

            $request = request();
            if (!$request->route()) {
                $view->with('visitorStats', $defaultStats);
                return;
            }

            $routeName = $request->route()->getName();
            $cacheKey = 'visitor_stats_';
            
            // [PERBAIKAN] Inisialisasi filter expression sebagai null
            $filterExpression = null;

            // 1. Logika untuk statistik spesifik per kecamatan
            if ($view->getName() === 'layouts.app' && $routeName === 'kecamatan.show' && $request->route('kecamatan')) {
                $kecamatan = $request->route('kecamatan');
                $cacheKey .= 'kecamatan_' . $kecamatan->slug;
                $pagePath = '/kecamatan/' . $kecamatan->slug;
                
                // [PERBAIKAN] Membuat filter expression dengan struktur yang benar untuk GA4
                $filterExpression = new FilterExpression([
                    'filter' => new Filter([
                        'field_name' => 'pagePath',
                        'string_filter' => new StringFilter([
                            'match_type' => MatchType::EXACT,
                            'value' => $pagePath,
                        ]),
                    ]),
                ]);

            // 2. Logika untuk statistik global di dashboard
            } elseif ($routeName === 'dashboard') {
                $cacheKey .= 'global_dashboard';
            
            // 3. Fallback untuk footer
            } else {
                 $cacheKey .= 'global_footer';
            }

            try {
                // Menggunakan $filterExpression di dalam closure
                $stats = Cache::remember($cacheKey, now()->addMinutes(15), function () use ($filterExpression) {
                    
                    // Query untuk total pengunjung
                    $totalVisitorsQuery = Analytics::get(
                        Period::years(1),
                        ['totalUsers'],
                        [], // dimensions
                        10, // limit
                        [], // orderBy
                        0,  // [PERBAIKAN] Menambahkan nilai 0 untuk offset (argumen ke-6)
                        $filterExpression // Filter sekarang menjadi argumen ke-7
                    );
                    $totalVisitors = $totalVisitorsQuery->first()['totalUsers'] ?? 0;

                    // Query untuk pengunjung hari ini
                    $todayVisitorsQuery = Analytics::get(
                        Period::days(1),
                        ['activeUsers'],
                        [], // dimensions
                        10, // limit
                        [], // orderBy
                        0,  // [PERBAIKAN] Menambahkan nilai 0 untuk offset (argumen ke-6)
                        $filterExpression // Filter sekarang menjadi argumen ke-7
                    );
                    $todayVisitors = $todayVisitorsQuery->first()['activeUsers'] ?? 0;

                    // Query untuk pengguna online (realtime)
                    $onlineUsersQuery = Analytics::get(
                        Period::create(now()->subMinutes(5), now()),
                        ['activeUsers'],
                        [], // dimensions
                        10, // limit
                        [], // orderBy
                        0,  // [PERBAIKAN] Menambahkan nilai 0 untuk offset (argumen ke-6)
                        $filterExpression // Filter sekarang menjadi argumen ke-7
                    );
                    $onlineUsers = $onlineUsersQuery->first()['activeUsers'] ?? 0;
                    
                    return [
                        'online' => $onlineUsers,
                        'today'  => $todayVisitors,
                        'total'  => $totalVisitors,
                    ];
                });

                $view->with('visitorStats', $stats);

            } catch (\Exception $e) {
                Log::error('Google Analytics API Error: ' . $e->getMessage());
                $view->with('visitorStats', $defaultStats);
            }
        });
    }
}