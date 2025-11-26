<?php

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'gender',
        'nation',
        'birthday',
        'email',
        'phone',
        'document',
        'document_type'
    ];
    public static function create(array $data)
    {
        return static::query()->create($data);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }
};
