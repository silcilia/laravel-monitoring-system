<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Menampilkan daftar service
     */
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }

    /**
     * Menampilkan form tambah service
     */
    public function create()
    {
        return view('services.form');
    }

    /**
     * Menyimpan service baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'service_type' => 'required|in:HTTP,PING',
        ]);

        $service = Service::create([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'service_type' => $validated['service_type'],
            'last_status' => 'UNKNOWN',
        ]);

        return redirect()->route('services.index')->with('success', 'Service berhasil ditambahkan');
    }

    /**
     * Menampilkan form edit service
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.form', compact('service'));
    }

    /**
     * Mengupdate service
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'service_type' => 'required|in:HTTP,PING',
        ]);

        $service = Service::findOrFail($id);
        $service->update([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'service_type' => $validated['service_type'],
        ]);

        return redirect()->route('services.index')->with('success', 'Service berhasil diupdate');
    }

    /**
     * Menghapus service
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service berhasil dihapus');
    }
}