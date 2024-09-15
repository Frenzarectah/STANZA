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
        'price',
        'customer_id'
    ];
    public static function create(array $data) {
        
        $dailyPrice = $data['dailyPrice'];
        $departure = new DateTime($data['Partenza']);
        $arrive = new DateTime($data['Arrive']);
        $days = $departure->diff($arrive)->d;
        $person = $data['person'];
    
        $price = $days*$dailyPrice*$person;
        var_dump($price);
        $data['price'] = $price;
        error_log("Calcolo del prezzo: $price");

        return static::query()->create($data);
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }

}