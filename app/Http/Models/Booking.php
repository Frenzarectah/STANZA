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
        'dailyPrice',
        'customer_id',
        'price'
    ];
    public static function create(array $data) {
        
        $dailyPrice = $data['dailyPrice'];
        $departure = new DateTime($data['Partenza']);
        $arrive = new DateTime($data['Arrive']);
        $days = $departure->diff($arrive);
        $person = $data['person'];
    
        $price = $days->d*$dailyPrice*$person;
        $data['price'] = $price;

        return static::query()->create($data);
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }

}