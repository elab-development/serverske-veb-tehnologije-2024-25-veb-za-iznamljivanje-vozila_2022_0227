<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $table = 'vehicles';
    protected $fillable = [
        'brand',
        'model',
        'plate_number',
        'year',
        'price_per_day',
        'vehicle_type',
        'fuel_type',
        'transmission',
        'seats',
        'tank_capacity',
        'available',
        'image_url'
    ];
    protected $appends = ['image_full_url'];

    public function getImageFullUrlAttribute(): ?string
    {
        return $this->image_url ? asset($this->image_url) : null;
    }
    public function reservations(){
        return $this->hasMany(Reservation::class);
    }
}
