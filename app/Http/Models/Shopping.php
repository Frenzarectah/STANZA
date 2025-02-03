<?php

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    protected $fillable = [
        'prodotto',
        'qty'
    ];
    public static function create(array $data) {
        return static::query()->create($data);
    }
};
