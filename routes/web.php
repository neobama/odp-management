<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\OdpController;
use App\Http\Controllers\ClientController;
use App\Models\Odp;

Route::middleware(['auth'])->group(function () {
    Route::get('/', function (Request $request) { // Tambahkan `Request` di sini
        $query = $request->input('query'); // Variabel `$request` sekarang tersedia

        $odps = Odp::with(['clients'])->withCount('clients');

        // Filter pencarian
        if ($query) {
            $odps->where('name', 'like', "%{$query}%")
                 ->orWhereHas('clients', function ($q) use ($query) {
                     $q->where('name', 'like', "%{$query}%");
                 });
        }

        $totalOdps = Odp::count();
        $totalClients = Odp::withCount('clients')->get()->sum('clients_count');
        $fullOdps = Odp::withCount('clients')
            ->get()
            ->filter(fn($odp) => $odp->clients_count >= $odp->capacity)
            ->count();

        $odps = $odps->get();

        return view('welcome', compact('totalOdps', 'totalClients', 'fullOdps', 'odps', 'query'));
    })->name('home');

    Route::get('/find-odp', [OdpController::class, 'findOdpPage'])->name('find.odp.page');
    Route::post('/find-odp', [OdpController::class, 'findNearestOdp'])->name('find.nearest.odp');
    Route::post('/find-nearest-odp', [OdpController::class, 'findNearestOdp'])->name('find.nearest.odp');
    Route::resource('odps', OdpController::class);
    Route::get('odps/{odp}/clients', [ClientController::class, 'manage'])->name('clients.manage');
    Route::post('odps/{odp}/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::patch('clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
});



// Route untuk login dan logout (bebas dari middleware auth)
require __DIR__.'/auth.php';
