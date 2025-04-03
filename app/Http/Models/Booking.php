<?php

namespace App\Http\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'Nome',
        'Cognome',
        'Email',
        'tel',
        'Arrive',
        'Partenza',
        'person',
        'days',
        'customer_id'
    ];
    public static function create(array $data) {
        
        $departure = new DateTime($data['Partenza']);
        $arrive = new DateTime($data['Arrive']);
        $days = $departure->diff($arrive)->d;
        $data['days'] = $days;
        return static::query()->create($data);
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}