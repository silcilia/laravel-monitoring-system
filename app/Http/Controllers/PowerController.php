<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PowerLog;
use App\Models\Device;

class PowerController extends Controller
{
    /**
     * Menampilkan halaman monitoring power
     */
    public function index()
    {
        $devices = Device::all();
        
        // Ambil 10 data power log terakhir untuk chart
        $powerLogs = PowerLog::orderBy('timestamp', 'desc')->take(10)->get();
        $powerLogs = $powerLogs->reverse(); // Urutkan dari yang lama ke baru untuk chart
        
        $labels = [];
        $voltages = [];
        $currents = [];
        $powers = [];
        
        foreach ($powerLogs as $log) {
            $labels[] = $log->timestamp->format('H:i:s');
            $voltages[] = $log->voltage;
            $currents[] = $log->current;
            $powers[] = $log->power;
        }
        
        return view('services.power', compact('devices', 'labels', 'voltages', 'currents', 'powers'));
    }
}