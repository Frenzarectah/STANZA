<?php

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'country',
    ];
    public static function create(array $data) {
        return static::query()->create($data);
    }
}
