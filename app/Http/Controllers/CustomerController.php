<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use App\Models\Person;
use Faker\Factory as Faker;
use App\Models\Contact;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::getJoinedData()->paginate(100);
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
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:contacts,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $faker = Faker::create();

        $person = Person::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
        ]);

        $customer = Customer::create([
            'person_id' => $person->id,
            'relation_number' => $faker->unique()->numberBetween(100000, 999999),
        ]);

        Contact::create([
            'customer_id' => $customer->id,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'is_active' => true,
            // ...other required fields for Contact model...
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function edit($customer)
    {
        return view('customers.edit', compact('customer'));
    }
}
