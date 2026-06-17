<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Menampilkan daftar contact
     */
    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Menampilkan form tambah contact
     */
    public function create()
    {
        return view('contacts.form');
    }

    /**
     * Menyimpan contact baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'notification_channel' => 'nullable|in:WHATSAPP,EMAIL,BOTH',
        ]);

        Contact::create([
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'] ?? null,
            'notification_channel' => $validated['notification_channel'] ?? 'WHATSAPP',
            'is_active' => true,
        ]);

        return redirect()->route('contacts.index')->with('success', 'Kontak berhasil ditambahkan');
    }

    /**
     * Menampilkan form edit contact
     */
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.form', compact('contact'));
    }

    /**
     * Mengupdate contact
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'notification_channel' => 'nullable|in:WHATSAPP,EMAIL,BOTH',
            'is_active' => 'nullable|boolean',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update([
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'] ?? null,
            'notification_channel' => $validated['notification_channel'] ?? 'WHATSAPP',
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('contacts.index')->with('success', 'Kontak berhasil diupdate');
    }

    /**
     * Menghapus contact
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Kontak berhasil dihapus');
    }
}