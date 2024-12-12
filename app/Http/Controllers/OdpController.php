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
        // Log data yang diterima
        \Log::info('Received data: ' . json_encode($request->all()));
    
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    
        // Tambahkan default capacity jika tidak disertakan
        $data = $request->all();
        $data['capacity'] = $data['capacity'] ?? 0;
    
        // Simpan data ke database
        try {
            Odp::create($data);
            \Log::info('ODP successfully saved.');
        } catch (\Exception $e) {
            \Log::error('Error saving ODP: ' . $e->getMessage());
            return redirect()->route('odps.index')->with('error', 'Failed to save ODP.');
        }
    
        // Redirect kembali
        return redirect()->route('odps.index')->with('success', 'ODP added successfully.');
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
    
    public function findOdpPage()
    {
        $odps = Odp::all();
        \Log::info('ODPs fetched for find page:', $odps->toArray());
        return view('odps.find', compact('odps'));
    }
    public function findNearestOdp(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
    
        // Query ODP dengan subquery clients_count
        $odps = Odp::withCount('clients')
            ->having('clients_count', '<', \DB::raw('capacity'))
            ->get();
    
        if ($odps->isEmpty()) {
            return response()->json(['message' => 'No available ODP found'], 404);
        }
    
        // Hitung jarak menggunakan fungsi getRouteDistance
        $distances = [];
        foreach ($odps as $odp) {
            $distance = $this->haversineDistance($latitude, $longitude, $odp->latitude, $odp->longitude);
            if ($distance !== null) {
                $distances[] = [
                    'odp' => $odp,
                    'distance' => $distance,
                ];
            }
        }
    
        if (empty($distances)) {
            return response()->json(['message' => 'No route available to ODPs'], 404);
        }
    
        // Cari ODP dengan jarak terpendek
        usort($distances, fn($a, $b) => $a['distance'] <=> $b['distance']);
        $nearestOdp = $distances[0];
    
        return response()->json([
            'odp' => $nearestOdp['odp'],
            'distance' => round($nearestOdp['distance'], 2),
        ]);
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Radius bumi dalam kilometer
    
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);
    
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
    
        $a = sin($dlat / 2) * sin($dlat / 2) +
             cos($lat1) * cos($lat2) *
             sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    
        return $earthRadius * $c; // Jarak dalam kilometer
    }
    
        
    private function getRouteDistance($startLat, $startLng, $endLat, $endLng)
    {
        $url = "http://router.project-osrm.org/route/v1/driving/$startLng,$startLat;$endLng,$endLat?overview=false";
    
        try {
            $response = file_get_contents($url);
            $data = json_decode($response, true);
    
            if (isset($data['routes'][0]['distance'])) {
                return $data['routes'][0]['distance'] / 1000; // Konversi meter ke kilometer
            }
            return null;
        } catch (\Exception $e) {
            \Log::error('Error fetching route distance: ' . $e->getMessage());
            return null;
        }
    }
    

    public function show($id)
    {
    $odp = Odp::with('clients')->findOrFail($id);

    return view('odps.show', compact('odp'));
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
    
    // Query data summary
    $totalOdps = Odp::count();
    $totalClients = Odp::withCount('clients')->get()->sum('clients_count');
    $fullOdps = Odp::withCount('clients')->get()->filter(fn ($odp) => $odp->clients_count >= $odp->capacity)->count();

    // Query data ODP untuk tabel dan peta
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
