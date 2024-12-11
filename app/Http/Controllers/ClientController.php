<?php

namespace App\Http\Controllers;

use App\Models\Odp;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Odp $odp)
    {
        // Mengambil daftar klien untuk ODP tertentu
        $clients = $odp->clients;
        return view('clients.index', compact('odp', 'clients'));
    }

    public function store(Request $request, Odp $odp)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Validasi kapasitas ODP
        if ($odp->clients()->count() >= $odp->capacity) {
            return back()->with('error', 'ODP is full. Cannot add more clients.');
        }

        // Tambahkan klien ke ODP
        $odp->clients()->create($request->only('name'));

        return redirect()->route('clients.index', $odp)->with('success', 'Client added successfully.');
    }
}
