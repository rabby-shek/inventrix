<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\CreateCustomerRequest;
class CustomerController extends Controller
{
    public function index()
    {
        return view('people.customers');
    }

    public function store(CreateCustomerRequest $request) {
        $customer = Customer::create($request->validated());
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }
}
