<?php

namespace App\Http\Controllers;

use App\Models\Odp;
use Illuminate\Http\Request;

class OdpController extends Controller
{
    public function index()
    {
        $odps = Odp::with('clients')->get();
        return view('odps.index', compact('odps'));
    }

    public function create()
    {
        return view('odps.create');
    }

    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'capacity' => 'required|integer|min:1',
    ]);

    Odp::create($request->all());

    return redirect()->route('odps.index')->with('success', 'ODP created successfully.');
    }

    public function edit(Odp $odp)
    {
        return view('odps.edit', compact('odp'));
    }

    public function update(Request $request, Odp $odp)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'capacity' => 'required|integer|min:1',
        ]);

        $odp->update($request->all());
        return redirect()->route('odps.index')->with('success', 'ODP updated successfully.');
    }
    
    public function destroy(Odp $odp)
    {
        $odp->delete();
        return redirect()->route('odps.index')->with('success', 'ODP deleted successfully.');
    }
    public function summary(Request $request)
    {
    // Ambil kata kunci pencarian jika ada
    $search = $request->get('search');

    // Hitung total ODP dan total klien
    $totalOdps = Odp::count();
    $totalClients = Odp::withCount('clients')->get()->sum('clients_count');
    $fullOdps = Odp::withCount('clients')->get()->filter(fn ($odp) => $odp->clients_count >= $odp->capacity)->count();

    // Query data ODP dan filter berdasarkan pencarian
    $odps = Odp::with(['clients'])
        ->withCount('clients')
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhereHas('clients', function ($query) use ($search) {
                      $query->where('name', 'like', "%$search%");
                  });
        })
        ->get();

    return view('home', compact('totalOdps', 'totalClients', 'fullOdps', 'odps', 'search'));
    }


}
