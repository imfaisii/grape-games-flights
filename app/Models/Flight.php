<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'departureTimeZone',
        'arrivalTimeZone',
        'estimatedTime',
        'departureAirport',
        'arrivalAirport',
        'flightDate',
        'status',
        'airline',
        'flightNo',
        'departureTime',
        'arrivalTime'
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];
}
