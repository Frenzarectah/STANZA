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

    public $validate = [
        'name'      => 'required|max:50|string',
        'surname'   => 'required|max:50|string',
        'gender'    => 'required|max:10|in:male,female',
        'nation'    => 'required|string|max:3',
        'birthday'  => 'required|date',
        'email'     => 'required|email|max:50|unique:customers,email',
        'phone'     => 'max:15',
        'document'  => 'file|required|mimes:jpeg,png,pdf|max:5120',
        'document_type' => 'required|string|max:20|in:id_doc,driver_lic,passport'
    ];

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
        $this->validate($request, $this->validate);

        $data = $request->only(['name', 'surname', 'gender', 'nation', 'birthday', 'email', 'phone', 'document_type']);

        if ($request->hasFile('document')) {
            $file     = $request->file('document');
            $uploadPath = app()->basePath('public/uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $fileName);
            $data['document'] = 'uploads/' . $fileName;
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
        $this->validate($request, $this->validate);

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
