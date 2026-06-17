<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ==========================
        // Statistik Service
        // ==========================
        $services = Service::all();

        $total = $services->count();
        $up = $services->where('last_status', 'UP')->count();
        $warning = $services->where('last_status', 'WARNING')->count();
        $down = $services->where('last_status', 'DOWN')->count();

        $percent = $total > 0
            ? intval(($up / $total) * 100)
            : 0;

        // ==========================
        // Data Chart 7 Hari Terakhir
        // ==========================
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            $labels[] = $date->format('D');

            $dailyLogs = Log::whereDate(
                'created_at',
                $date->toDateString()
            )->get();

            if ($dailyLogs->count() > 0) {
                $upCount = $dailyLogs
                    ->where('status', 'UP')
                    ->count();

                $percentDay = intval(
                    ($upCount / $dailyLogs->count()) * 100
                );
            } else {
                $percentDay = 100;
            }

            $data[] = $percentDay;
        }

        return view(
            'dashboard.index',
            compact(
                'total',
                'up',
                'warning',
                'down',
                'percent',
                'labels',
                'data'
            )
        );
    }
}