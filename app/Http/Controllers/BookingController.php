<?php

namespace App\Http\Controllers;

use App\Http\Models\Booking;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class   BookingController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function index()
    {
        $bookings = Booking::all();
        return $this->successResponse($bookings);
    }
    public function store(Request $request)
    {
        $rules = [
            'Nome' => 'required|max:50|string',
            'Cognome' => 'required|max:30|string',
            'Email' => 'required|email',
            'tel' => 'required|string',
            'Arrive' => 'required|date',
            'Partenza' => 'required|date',
            'customer_id' => 'required',
            'dailyPrice' => 'required|integer',
            'person' => 'required|integer'
        ];
        $this->validate($request,$rules);
        $bookings = Booking::create($request->all());
        return $this->successResponse($bookings, Response::HTTP_CREATED);

    }
    public function show($book)
    {
        $book = Booking::findOrFail($book);
        return $this->successResponse($book);
    }
    public function update(Request $request, $book)
    {
         $rules = [
            'Nome' => 'required|max:50|string',
            'Cognome' => 'required|max:30|string',
            'Email' => 'required|email',
            'tel' => 'required|string',
            'Arrive' => 'required|date',
            'Partenza' => 'required|date',
        ];
        $this->validate($request,$rules);

    }
    public function destroy($book)
    {
        $book = Booking::destroy($book);
        return $this->successResponse($book,Response::HTTP_OK);
    }
    public function allbookings($customer_id){
        $customer_booking = Booking::where('customer_id','=',$customer_id)->get();
        if ($customer_booking->isEmpty()){
            return $this->successResponse("customer not in the database yet",Response::HTTP_OK);
            die();
        }
        return $customer_booking;
    }
}
