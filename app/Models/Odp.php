<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odp extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'latitude', 'longitude', 'capacity'];

    protected $attributes = [
        'capacity' => 16,
    ];
    
    public function clients()
    {
        return $this->hasMany(Client::class, 'odp_id');
    }
}
