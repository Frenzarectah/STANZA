<?php

namespace App\Http\Controllers;

use App\Http\Models\Customer;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    use ApiResponser;

    function public_path($path = '')
    {
        return app()->basePath('public') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function __construct()
    {
        //
    }

    public function index()
    {
        $customers = Customer::all();
        foreach ($customers as $customer) {
            if ($customer->document) {
                $customer->document_url = url($customer->document);
            }
        }
        return $this->successResponse($customers);
    }

    public function store(Request $request)
    {
        $rules = [
            'name'    => 'required|max:255|string',
            'gender'  => 'required|max:10|in:male,female',
            'country' => 'string|max:3',
            'document' => 'file|mimes:jpeg,png,pdf|max:5120' // NUOVA VALIDAZIONE (max 5MB)
        ];
        $this->validate($request, $rules);

        $data = $request->only(['name', 'gender', 'country']);

        // Upload del file se viene passato
        if ($request->hasFile('document')) {
            $file     = $request->file('document');
            $uploadPath = app()->basePath('public/uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $fileName);
            $data['document'] = 'uploads/' . $fileName; // Salva solo percorso relativo
        }

        $customer = Customer::create($data);
        return $this->successResponse($customer, Response::HTTP_CREATED);
    }

    public function show($customer)
    {
        $customer = Customer::findOrFail($customer);
        if ($customer->document) {
            $customer->document_url = url($customer->document);
        }

        return $this->successResponse($customer);
    }

    public function update(Request $request, $customer)
    {
        $rules = [
            'name'    => 'required|max:255|string',
            'gender'  => 'required|max:10|in:male,female',
            'country' => 'string|max:3',
            'document' => 'file|mimes:jpeg,png,pdf|max:5120'
        ];
        $this->validate($request, $rules);

        $customer = Customer::findOrFail($customer);
        $data = $request->only(['name', 'gender', 'country']);


        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $uploadPath = app()->basePath('public/uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $fileName);
            $data['document'] = 'uploads/' . $fileName;
        }
        $customer->update($data);
        return $this->successResponse($customer);
    }

    public function destroy($customer)
    {
        $customer = Customer::destroy($customer);
        return $this->successResponse($customer, Response::HTTP_OK);
    }
}
