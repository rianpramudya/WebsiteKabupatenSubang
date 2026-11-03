<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\Filter\StringFilter;
use Google\Analytics\Data\V1beta\Filter\StringFilter\MatchType;
use Google\Analytics\Data\V1beta\FilterExpression;

class AnalyticsServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }

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

            $filterExpression = null;

            if ($view->getName() === 'layouts.app' && $routeName === 'kecamatan.show' && $request->route('kecamatan')) {
                $kecamatan = $request->route('kecamatan');
                $cacheKey .= 'kecamatan_' . $kecamatan->slug;
                $pagePath = '/kecamatan/' . $kecamatan->slug;

                $filterExpression = new FilterExpression([
                    'filter' => new Filter([
                        'field_name' => 'pagePath',
                        'string_filter' => new StringFilter([
                            'match_type' => MatchType::EXACT,
                            'value' => $pagePath,
                        ]),
                    ]),
                ]);

            } elseif ($routeName === 'dashboard') {
                $cacheKey .= 'global_dashboard';

            } else {
                 $cacheKey .= 'global_footer';
            }

            try {

                $stats = Cache::remember($cacheKey, now()->addMinutes(15), function () use ($filterExpression) {

                    $totalVisitorsQuery = Analytics::get(
                        Period::years(1),
                        ['totalUsers'],
                        [],
                        10,
                        [],
                        0,
                        $filterExpression
                    );
                    $totalVisitors = $totalVisitorsQuery->first()['totalUsers'] ?? 0;

                    $todayVisitorsQuery = Analytics::get(
                        Period::days(1),
                        ['activeUsers'],
                        [],
                        10,
                        [],
                        0,
                        $filterExpression
                    );
                    $todayVisitors = $todayVisitorsQuery->first()['activeUsers'] ?? 0;

                    $onlineUsersQuery = Analytics::get(
                        Period::create(now()->subMinutes(5), now()),
                        ['activeUsers'],
                        [],
                        10,
                        [],
                        0,
                        $filterExpression
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