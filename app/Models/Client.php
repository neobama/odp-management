<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // Izinkan kolom ini untuk mass assignment
    protected $fillable = ['name', 'odp_id'];

    // Relasi ke ODP
    public function odp()
    {
        return $this->belongsTo(Odp::class);
    }
}
