<?php

namespace App\Http\Controllers;

use App\Http\Models\Customer;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class   CustomerController extends Controller
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
        $customers = Customer::all();
        return $this->successResponse($customers);
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255|string',
            'gender' => 'required|max:10|in:male,female',
            'country' => 'string|max:3'
        ];
        $this->validate($request,$rules);
        $customer = Customer::create($request->all());
        return $this->successResponse($customer, Response::HTTP_CREATED);

    }
    public function show($customer)
    {
        $customer = Customer::findOrFail($customer);
        return $this->successResponse($customer);
    }
    public function update(Request $request, $customer)
    {
        $rules = [
            'name' => 'required|max:255|string',
            'gender' => 'required|max:10|in:male,female',
            'country' => 'string|max:3'
        ];
        $this->validate($request,$rules);

    }
    public function destroy($customer)
    {
        $customer = Customer::destroy($customer);
        return $this->successResponse($customer,Response::HTTP_OK);
    }
}
