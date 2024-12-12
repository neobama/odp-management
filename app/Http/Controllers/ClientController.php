<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Odp;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Halaman untuk mengelola klien di ODP tertentu
    public function manage(Odp $odp)
    {
        // Ambil semua klien terkait ODP ini
        $clients = $odp->clients;

        return view('clients.manage', compact('odp', 'clients'));
    }

    // Tambahkan klien baru ke ODP
    public function store(Request $request, Odp $odp)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $odp->clients()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('clients.manage', $odp->id)->with('success', 'Client added successfully.');
    }

    // Update klien yang ada
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $client->update([
            'name' => $request->name,
        ]);

        return redirect()->route('clients.manage', $client->odp_id)->with('success', 'Client updated successfully.');
    }

    // Hapus klien yang ada
    public function destroy(Client $client)
    {
        // Hapus klien
        $client->delete();
    
        // Redirect kembali ke halaman klien ODP
        return redirect()->route('clients.manage', $client->odp_id)->with('success', 'Client deleted successfully.');
    }
    

}
