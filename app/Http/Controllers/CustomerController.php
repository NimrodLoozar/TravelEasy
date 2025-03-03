<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::getJoinedData()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function show($customer)
    {
        return view('customers.show', compact('customer'));
    }

    public function store(Request $request)
    {
        return redirect()->route('customers.index');
    }

    public function edit($customer)
    {
        return view('customers.edit', compact('customer'));
    }
}
