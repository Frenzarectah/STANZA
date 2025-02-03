<?php

namespace App\Http\Controllers;

use App\Http\Models\Shopping;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class   ShoppingController extends Controller
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
        $shopping_list = Shopping::all();
        return $this->successResponse($shopping_list);
    }
    public function store(Request $request)
    {
        $rules = [
            'prodotto' => 'required|string',
            'qty' => 'integer',
        ];
        $this->validate($request,$rules);
        $shopping = Shopping::create($request->all());
        return $this->successResponse($shopping, Response::HTTP_CREATED);

    }
    public function show($item)
    {
        $item = Shopping::findOrFail($item);
        return $this->successResponse($item);
    }
    public function update(Request $request, $item)
    {
        $rules = [
            'prodotto' => 'required|string',
            'qty' => 'integer',
        ];
        $this->validate($request,$rules);

        $shopping = Shopping::findOrFail($item);
        $shopping->update($request->all());
    
        return $this->successResponse($shopping);
    }
    public function destroy($item)
    {
        $item = Shopping::destroy($item);
        return $this->successResponse($item,Response::HTTP_OK);
    }
}
