<?php

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'Nome',
        'Cognome',
        'Email',
        'tel',
        'Arrive',
        'Partenza'
    ];
    public static function create(array $data) {
        return static::query()->create($data);
    }
}