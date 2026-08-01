<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\CreateCustomerRequest;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::paginate(10);
        $totalCustomers = Customer::count();
        $activeCustomers = Customer::where('status', 'active')->count();
        $newThisMonth = Customer::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();
        return view('people.customers', compact('customers', 'totalCustomers', 'activeCustomers', 'newThisMonth'));
    }

    public function store(CreateCustomerRequest $request)
    {
        Customer::create($request->validated());
        return redirect()->route('people.customers')->with('success', 'Customer created successfully.');
    }


    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('people.customers')->with('success', 'Customer deleted successfully.');
    }
}
